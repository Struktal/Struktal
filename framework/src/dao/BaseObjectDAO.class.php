<?php

class BaseObjectDAO {
    private string $CLASS_INSTANCE = "";
    
    public function __construct($CLASS_INSTANCE) {
        $this->CLASS_INSTANCE = $CLASS_INSTANCE;
    }
    
    /**
     * Saves an Object with its current Attributes to the Database
     * @param BaseObject $object
     * @return bool
     */
    public function save(BaseObject $object): bool {
        if($this->tableExists(get_class($object))) {
            $tableName = get_class($object);
            $classProperties = get_class_vars(get_class($object));
            if($object->getId() === null) {
                // Object doesn't exist, perform INSERT
                $sql = "INSERT INTO {$tableName} VALUES (";
                foreach($classProperties as $property => $value) {
                    $sql .= ":{$property}, ";
                }
                $sql = substr($sql, 0, -2);
                $sql .= ")";
        
                $stmt = Database::getConnection()->prepare($sql);
                foreach($classProperties as $property => $value) {
                    if($object->$property instanceof DateTime) {
                        $date = $object->$property->format("Y-m-d H:i:s");
                        $stmt->bindParam("{$property}", $date, PDO::PARAM_STR);
                    } else if(is_bool($object->$property)) {
                        $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_BOOL);
                    } else if(is_int($object->$property)) {
                        $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_INT);
                    } else if(is_null($object->$property)) {
                        $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_STR);
                    }
                }
                $stmt->execute();
        
                $object->id = Database::getConnection()->lastInsertId();
                return true;
            } else {
                // Object already exists, perform UPDATE
                $sql = "UPDATE {$tableName} SET (";
                foreach($classProperties as $property => $value) {
                    if($property !== "id" && $property !== "created") {
                        $sql .= "{$property} = :{$property}, ";
                    }
                }
                $sql = substr($sql, 0, -2);
                $sql .= ") WHERE id = :id";
                
                $stmt = Database::getConnection()->prepare($sql);
                foreach($classProperties as $property => $value) {
                    if($property !== "created") {
                        if($object->$property instanceof DateTime) {
                            $date = $object->$property->format("Y-m-d H:i:s");
                            $stmt->bindParam("{$property}", $date, PDO::PARAM_STR);
                        } else if(is_bool($object->$property)) {
                            $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_BOOL);
                        } else if(is_int($object->$property)) {
                            $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_INT);
                        } else if(is_null($object->$property)) {
                            $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_NULL);
                        } else {
                            $stmt->bindParam("{$property}", $object->$property, PDO::PARAM_STR);
                        }
                    }
                }
                $stmt->execute();
                return true;
            }
        } else {
            Logger::getLogger("BaseObjectDAO")->error("Critical: Trying to save " . get_class($object) . " but table does not exist");
        }
        
        return false;
    }
    
    /**
     * Gets an Object from the Database
     * The Object will be returned as an Instance of the corresponding Class
     * @param array  $filter
     * @param string $orderBy
     * @param bool   $orderAsc
     * @param int    $limit
     * @param int    $offset
     * @return BaseObject|null
     */
    public function getObject(array $filter = array(), string $orderBy = "id", bool $orderAsc = true, int $limit = 1, int $offset = 0): ?BaseObject {
        $sql = "SELECT * FROM " . $this->CLASS_INSTANCE;
        if(count($filter) > 0) {
            $sql .= " WHERE ";
            foreach($filter as $key => $value) {
                $sql .= "{$key} = :{$key} AND ";
            }
            $sql = substr($sql, 0, -5);
        }
        $sql .= " ORDER BY {$orderBy} " . ($orderAsc ? "ASC" : "DESC");
        $sql .= " LIMIT {$limit} OFFSET {$offset}";
        
        $stmt = Database::getConnection()->prepare($sql);
        foreach($filter as $key => $value) {
            $stmt->bindParam(":{$key}", $value);
        }
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $object = new $this->CLASS_INSTANCE();
            $object->fromArray($result);
            return $object;
        } else {
            return null;
        }
    }
    
    /**
     * Gets multiple Objects from the Database at once
     * The Objects will be returned as an Array of Instances of the corresponding Class
     * @param array  $filter
     * @param string $orderBy
     * @param bool   $orderAsc
     * @param int    $limit
     * @param int    $offset
     * @return array
     */
    public function getObjects(array $filter = array(), string $orderBy = "id", bool $orderAsc = true, int $limit = 1, int $offset = 0): array {
        $sql = "SELECT * FROM " . $this->CLASS_INSTANCE;
        if(count($filter) > 0) {
            $sql .= " WHERE ";
            foreach($filter as $key => $value) {
                $sql .= "{$key} = :{$key} AND ";
            }
            $sql = substr($sql, 0, -5);
        }
        $sql .= " ORDER BY {$orderBy} " . ($orderAsc ? "ASC" : "DESC");
        $sql .= " LIMIT {$limit} OFFSET {$offset}";
    
        $stmt = Database::getConnection()->prepare($sql);
        foreach($filter as $key => $value) {
            $stmt->bindParam(":{$key}", $value);
        }
        $stmt->execute();
        
        $objects = array();
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $object = new $this->CLASS_INSTANCE();
            $object->fromArray($result);
            $objects[] = $object;
        }
        
        return $objects;
    }
    
    /**
     * Checks whether the Table for the specified Class exists
     * @param string $tableName
     * @return bool
     */
    public function tableExists(string $tableName) {
        $stmt = Database::getConnection()->prepare("SHOW TABLES LIKE :tableName");
        $stmt->bindParam(":tableName", $tableName);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}
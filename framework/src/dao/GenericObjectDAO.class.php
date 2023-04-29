<?php

class GenericObjectDAO {
    private string $CLASS_INSTANCE = "";
    
    public function __construct($CLASS_INSTANCE) {
        $this->CLASS_INSTANCE = $CLASS_INSTANCE;
    }
    
    /**
     * Save an Object with its current Attributes to the Database
     * @param GenericObject $object
     * @return bool
     */
    public function save(GenericObject $object): bool {
        if($this->tableExists(get_class($object))) {
            $tableName = get_class($object);
            $objectProperties = get_object_vars($object);
            if($object->getId() === null) {
                // Object doesn't exist, perform INSERT
                $sql = "INSERT INTO `{$tableName}` (";
                foreach($objectProperties as $property => $value) {
                    $sql .= "`{$property}`, ";
                }
                $sql = substr($sql, 0, -2);
                $sql .= ") VALUES (";
                foreach($objectProperties as $property => $value) {
                    $sql .= ":{$property}, ";
                }
                $sql = substr($sql, 0, -2);
                $sql .= ")";
        
                $stmt = Database::getConnection()->prepare($sql);
                foreach($objectProperties as $property => $value) {
                    if($value instanceof DateTime) {
                        $date = $value->format("Y-m-d H:i:s");
                        $stmt->bindValue("{$property}", $date, PDO::PARAM_STR);
                    } else if(is_bool($value)) {
                        $stmt->bindValue("{$property}", $value, PDO::PARAM_BOOL);
                    } else if(is_int($value)) {
                        $stmt->bindValue("{$property}", $value, PDO::PARAM_INT);
                    } else if(is_null($value)) {
                        $stmt->bindValue("{$property}", $value, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue("{$property}", $value, PDO::PARAM_STR);
                    }
                }
                $stmt->execute();
        
                $object->id = Database::getConnection()->lastInsertId();
                return true;
            } else {
                // Object already exists, perform UPDATE
                $sql = "UPDATE `{$tableName}` SET ";
                foreach($objectProperties as $property => $value) {
                    if($property !== "created" && $property !== "id") {
                        $sql .= "`{$property}` = :{$property}, ";
                    }
                }
                $sql = substr($sql, 0, -2);
                $sql .= " WHERE `id` = :id";

                $stmt = Database::getConnection()->prepare($sql);
                foreach($objectProperties as $property => $value) {
                    if($property !== "created" && $property !== "id") {
                        if($value instanceof DateTime) {
                            $date = $value->format("Y-m-d H:i:s");
                            $stmt->bindValue("{$property}", $date, PDO::PARAM_STR);
                        } else if(is_bool($value)) {
                            $stmt->bindValue("{$property}", $value, PDO::PARAM_BOOL);
                        } else if(is_int($value)) {
                            $stmt->bindValue("{$property}", $value, PDO::PARAM_INT);
                        } else if(is_null($value)) {
                            $stmt->bindValue("{$property}", $value, PDO::PARAM_NULL);
                        } else {
                            $stmt->bindValue("{$property}", $value, PDO::PARAM_STR);
                        }
                    }
                }
                $stmt->bindValue(":id", $object->id, PDO::PARAM_INT);
                $stmt->execute();

                return true;
            }
        } else {
            Logger::getLogger("GenericObjectDAO")->error("Critical: Trying to save " . get_class($object) . " but table does not exist");
        }
        
        return false;
    }
    
    /**
     * Get an Object from the Database
     * The Object will be returned as an Instance of the corresponding Class
     * @param array  $filter
     * @param string $orderBy
     * @param bool   $orderAsc
     * @param int    $limit
     * @param int    $offset
     * @return GenericObject|null
     */
    public function getObject(array $filter, string $orderBy = "id", bool $orderAsc = true, int $limit = 1, int $offset = 0): ?GenericObject {
        if($this->tableExists($this->CLASS_INSTANCE)) {
            $sql = "SELECT * FROM `" . $this->CLASS_INSTANCE . "`";
            
            // Add Deleted Flag if not explicitly set
            if(!array_key_exists("deleted", $filter)) {
                $filter["deleted"] = false;
            }
            
            if(count($filter) > 0) {
                $sql .= " WHERE ";
                foreach($filter as $key => $value) {
                    $sql .= "`{$key}` = :{$key} AND ";
                }
                $sql = substr($sql, 0, -5);
            }
            $sql .= " ORDER BY `{$orderBy}` " . ($orderAsc ? "ASC" : "DESC");
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
    
            $stmt = Database::getConnection()->prepare($sql);
            foreach($filter as $key => $value) {
                $stmt->bindValue("{$key}", $value);
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
        } else {
            Logger::getLogger("GenericObjectDAO")->error("Critical: Trying to get " . $this->CLASS_INSTANCE . " but table does not exist");
        }
        
        return null;
    }
    
    /**
     * Get multiple Objects from the Database at once
     * The Objects will be returned as an Array of Instances of the corresponding Class
     * @param array  $filter
     * @param string $orderBy
     * @param bool   $orderAsc
     * @param int    $limit
     * @param int    $offset
     * @return array
     */
    public function getObjects(array $filter = array("deleted" => false), string $orderBy = "id", bool $orderAsc = true, int $limit = -1, int $offset = 0): array {
        if($this->tableExists($this->CLASS_INSTANCE)) {
            $sql = "SELECT * FROM `" . $this->CLASS_INSTANCE . "`";
    
            // Add Deleted Flag if not explicitly set
            if(!array_key_exists("deleted", $filter)) {
                $filter["deleted"] = false;
            }
            
            if(count($filter) > 0) {
                $sql .= " WHERE ";
                foreach($filter as $key => $value) {
                    $sql .= "`{$key}` = :{$key} AND ";
                }
                $sql = substr($sql, 0, -5);
            }
            $sql .= " ORDER BY `{$orderBy}` " . ($orderAsc ? "ASC" : "DESC");
            if($limit >= 0) {
                $sql .= " LIMIT {$limit} OFFSET {$offset}";
            }
    
            $stmt = Database::getConnection()->prepare($sql);
            foreach($filter as $key => $value) {
                $stmt->bindValue("{$key}", $value);
            }
            $stmt->execute();
    
            $objects = array();
            while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $object = new $this->CLASS_INSTANCE();
                $object->fromArray($result);
                $objects[] = $object;
            }
    
            return $objects;
        } else {
            Logger::getLogger("GenericObjectDAO")->error("Critical: Trying to get " . $this->CLASS_INSTANCE . " but table does not exist");
        }
    
        return array();
    }
    
    /**
     * Check whether the Table for the specified Class exists
     * @param string $tableName
     * @return bool
     */
    public function tableExists(string $tableName) {
        $stmt = Database::getConnection()->prepare("SHOW TABLES LIKE :tableName");
        $stmt->bindValue(":tableName", $tableName);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}

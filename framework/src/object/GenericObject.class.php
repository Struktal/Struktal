<?php

class GenericObject {
    private static ?GenericObjectDAO $dao = null;
    
    public ?int $id;
    public DateTime $created;
    public DateTime $updated;
    public bool $deleted;

    public function __construct() {
        $this->id = null;
        $this->created = new DateTime();
        $this->updated = new DateTime();
        $this->deleted = false;
    }
    
    /**
     * Gets the Data Access Object for this Class
     * @return GenericObjectDAO
     */
    public static function dao(): GenericObjectDAO {
        if(self::$dao === null) {
            if(class_exists(get_called_class() . "DAO")) {
                $daoClassName = get_called_class() . "DAO";
                self::$dao = new $daoClassName(get_called_class());
            } else {
                Logger::getLogger("GenericObject")->error("DAO for Class " . get_called_class() . " requested but not found");
            }
        }
        
        return self::$dao;
    }

    /**
     * Imports the Data from an Array to the Object
     * @param array $data
     * @return void
     */
    public function fromArray(array $data): void {
        $classProperties = get_object_vars($this);
        foreach($classProperties as $property => $value) {
            if(array_key_exists($property, $data)) {
                if($this->$property instanceof DateTime) {
                    $this->$property = DateTime::createFromFormat("Y-m-d H:i:s", $data[$property]);
                } else {
                    $this->$property = $data[$property];
                }
            } else {
                Logger::getLogger("GenericObject")->error("Critical: Property \"{$property}\" does not exist in Data Array");
            }
        }
    }

    /**
     * Exports the Object to an Array
     * @return array
     */
    public function toArray(): array {
        $classProperties = get_object_vars($this);
        $data = array();
        foreach($classProperties as $property => $value) {
            $data[$property] = $this->$property;
        }

        return $data;
    }
    
    /**
     * @return ?int
     */
    public function getId(): ?int {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    private function setId(int $id): void {
        $this->id = $id;
    }
    
    /**
     * @return DateTime
     */
    public function getCreated(): DateTime {
        return $this->created;
    }
    
    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void {
        $this->created = $created;
    }
    
    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime {
        return $this->updated;
    }
    
    /**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated): void {
        $this->updated = $updated;
    }
    
    /**
     * @return bool
     */
    public function isDeleted(): bool {
        return $this->deleted;
    }
    
    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void {
        $this->deleted = $deleted;
    }
}
<?php

class GenericObject {
    private static array $dao = [];
    
    public ?int $id;
    public DateTime $created;
    public DateTime $updated;

    public function __construct() {
        $this->id = null;
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }
    
    /**
     * Get the Data Access Object for this Class
     * @return GenericObjectDAO
     */
    public static function dao(): GenericObjectDAO {
        if(!(array_key_exists(get_called_class(), self::$dao))) {
            if(class_exists(get_called_class() . "DAO")) {
                $daoClassName = get_called_class() . "DAO";
                self::$dao[get_called_class()] = new $daoClassName(get_called_class());
            } else {
                Logger::getLogger("GenericObject")->error("DAO for Class " . get_called_class() . " requested but not found");
            }
        }
        
        return self::$dao[get_called_class()];
    }

    /**
     * Import Data from an Array to the Object
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
     * Export the Object's Data to an Array
     * @return array
     */
    public function toArray(): array {
        $classProperties = get_object_vars($this);
        $data = [];
        foreach($classProperties as $property => $value) {
            $data[$property] = $this->$property;
        }

        return $data;
    }
    
    /**
     * Get the Object's ID
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }
    
    /**
     * Set the Object's ID
     * @param int $id
     */
    private function setId(int $id): void {
        $this->id = $id;
    }
    
    /**
     * Get the Object's Creation Date
     * @return DateTime
     */
    public function getCreated(): DateTime {
        return $this->created;
    }
    
    /**
     * Set the Object's Creation Date
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void {
        $this->created = $created;
    }
    
    /**
     * Get the Object's Last Update Date
     * @return DateTime
     */
    public function getUpdated(): DateTime {
        return $this->updated;
    }
    
    /**
     * Set the Object's Last Update Date
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated): void {
        $this->updated = $updated;
    }
}

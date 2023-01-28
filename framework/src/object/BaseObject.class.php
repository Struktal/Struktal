<?php

class BaseObject {
    public int $id;
    public DateTime $created;
    public DateTime $updated;
    public bool $deleted;

    public function __construct() {
        $this->id = -1;
        $this->created = new DateTime();
        $this->updated = new DateTime();
        $this->deleted = false;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
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

    /**
     * Imports the Data from an Array to the Object
     * @param array $data
     * @return void
     */
    public function fromArray(array $data): void {
        $classProperties = get_class_vars(get_class($this));
        foreach($classProperties as $property => $value) {
            if(array_key_exists($property, $data)) {
                $this->$property = $data[$property];
            } else {
                Logger::getLogger("BaseObject")->error("Critical: Property \"{$property}\" does not exist in Data Array");
            }
        }
    }

    /**
     * Exports the Object to an Array
     * @return array
     */
    public function toArray(): array {
        $classProperties = get_class_vars(get_class($this));
        $data = array();
        foreach($classProperties as $property => $value) {
            $data[$property] = $this->$property;
        }

        return $data;
    }
}

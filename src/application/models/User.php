<?php

namespace alexshent\webapp\application\models;

class User extends \alexshent\webapp\core\ActiveRecord implements \JsonSerializable {
    
    protected $firstName;
    protected $secondName;
    protected $position;
    
    public function __construct() {
        parent::__construct("uuid");
    }
    
    public function getFirstName() : string {
        return $this->firstName;
    }

    public function setFirstName($firstName) : void {
        $this->firstName = $firstName;
    }
    
    public function getSecondName() : string {
        return $this->secondName;
    }

    public function setSecondName($secondName) : void {
        $this->secondName = $secondName;
    }
    
    public function getPosition() : string {
        return $this->position;
    }

    public function setPosition($position) : void {
        $this->position = $position;
    }
    
    protected static function getTableName() : string {
        return 'users';
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }    
}

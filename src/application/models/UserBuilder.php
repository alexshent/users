<?php

namespace alexshent\webapp\application\models;

use alexshent\webapp\application\models\User;

class UserBuilder {

    private $id;
    private $firstName;
    private $secondName;
    private $position;

    public function withId($id) {
        $this->id = $id;
        return $this;
    }

    public function withFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function withSecondName($secondName) {
        $this->secondName = $secondName;
        return $this;
    }

    public function withPosition($position) {
        $this->position = $position;
        return $this;
    }

    public function build() : User {
        $user = new User();
        $user->setId($this->id);
        $user->setFirstName($this->firstName);
        $user->setSecondName($this->secondName);
        $user->setPosition($this->position);
        return $user;
    }
}
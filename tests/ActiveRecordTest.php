<?php

use PHPUnit\Framework\TestCase;
use alexshent\webapp\core\Database;
use alexshent\webapp\core\ActiveRecord;
use alexshent\webapp\application\models\User;
use alexshent\webapp\application\models\UserBuilder;

class ActiveRecordTest extends TestCase {
    
    public function testSetCustomField() {
        // given
        $expected = "CustomFieldTest";
        
        // when
        $user = new User();
        $user->hello_world = "CustomFieldTest";
        $actual = $user->helloWorld;
        
        // then
        $this->assertEquals($expected, $actual);
    }
    
    public function testInsert() {
        // given
        $config = [
            'database_type' => 'mysql',
            'host' => '172.17.0.2',
            'database_name' => 'hello',
            'user' => 'root',
            'password' => '1',
            'charset' => 'utf8'
        ];
        Database::getInstance($config);
        $expected = 'Smith';
        
        // when
        $userBuilder = new UserBuilder();
        $user = $userBuilder->withFirstName('John')->withSecondName('Smith')->withPosition('developer')->build();
        $user->save();
        $id = $user->getId();
        $userFromDatabase = User::getById($id);
        $actual = $userFromDatabase->getSecondName();
        
        // then
        $this->assertEquals($expected, $actual);
    }
}

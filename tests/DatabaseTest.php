<?php

use PHPUnit\Framework\TestCase;
use alexshent\webapp\core\Database;

class DatabaseTest extends TestCase {
    
    public function testGetInstance() {
        // given
        $config = [
            'database_type' => 'mysql',
            'host' => '172.17.0.2',
            'database_name' => 'hello',
            'user' => 'root',
            'password' => '1',
            'charset' => 'utf8'
        ];
        $expected = true;
        
        // when
        $actual = !empty(Database::getInstance($config));
        
        // then
        $this->assertEquals($expected, $actual);
    }
    
    public function testQuery() {
        // given
        $config = [
            'database_type' => 'mysql',
            'host' => '172.17.0.2',
            'database_name' => 'hello',
            'user' => 'root',
            'password' => '1',
            'charset' => 'utf8'
        ];
        $sql = "DESCRIBE users";
        $expected = new \stdClass();
        $expected->Field = 'id';
        $expected->Type = 'char(36)';
        $expected->Null = 'NO';
        $expected->Key = 'PRI';
        $expected->Default = '';
        $expected->Extra = '';
        
        // when
        $actual = Database::getInstance($config)->query($sql);
        
        // then
        $this->assertEquals($expected, $actual[0]);
    }
}

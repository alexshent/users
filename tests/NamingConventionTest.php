<?php

use PHPUnit\Framework\TestCase;
use alexshent\webapp\core\NamingConvention;

class NamingConventionTest extends TestCase {
    
    public function testUnderscoreToCamelCase() {
        // given
        $underscoreName = "my_name_is_john_smith";
        $expected = "myNameIsJohnSmith";
        
        // when
        $actual = NamingConvention::underscoreToCamelCase($underscoreName);
        
        // then
        $this->assertEquals($expected, $actual);
    }
    
    public function testCamelCaseToUnderscore() {
        // given
        $camelCaseName = "myNameIsJohnSmith";
        $expected = "my_name_is_john_smith";
        
        // when
        $actual = NamingConvention::camelCaseToUnderscore($camelCaseName);
        
        // then
        $this->assertEquals($expected, $actual);
    }
    
    public function testHyphenToStudlyCaps() {
        // given
        $hyphenName = "my-name-is-john-smith";
        $expected = "MyNameIsJohnSmith";
        
        // when
        $actual = NamingConvention::hyphenToStudlyCaps($hyphenName);
        
        // then
        $this->assertEquals($expected, $actual);
    }
    
    public function testHyphenToCamelCase() {
        // given
        $hyphenName = "my-name-is-john-smith";
        $expected = "myNameIsJohnSmith";
        
        // when
        $actual = NamingConvention::hyphenToCamelCase($hyphenName);
        
        // then
        $this->assertEquals($expected, $actual);
    }
}

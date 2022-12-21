<?php

use PHPUnit\Framework\TestCase;
use alexshent\webapp\core\View;

class ViewTest extends TestCase {
    
    public function testRender() {
        // given
        $expected = "hello world";
        
        // when
        $view = new View("test");
        $actual = $view->render("hello", ['w' => 'world'], true);
        
        // then
        $this->assertEquals($expected, $actual);
    }
}

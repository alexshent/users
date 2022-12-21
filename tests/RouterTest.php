<?php

use PHPUnit\Framework\TestCase;
use alexshent\webapp\core\Router;

class RouterTest extends TestCase {
    
    public function testAddRoutes() {
        // given
        $expected = [
            '/^\/$/i' => [
                'controller' => 'Main',
                'action' => 'index'
            ],
            '/^\/(?P<controller>[a-z-]+)$/i' => [
                'action' => 'index'
            ],
            '/^\/(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/i' => []
        ];
        
        // when
        $router = new Router('alexshent\\webapp\\application\\controllers\\');
        $router->add('/', ['controller' => 'Main', 'action' => 'index']);
        $router->add('/{controller}', ['action' => 'index']);
        $router->add('/{controller}/{action}');
        $actual = $router->getRoutes();
        
        // then
        $this->assertEquals($expected, $actual);
    }
}

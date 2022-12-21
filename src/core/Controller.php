<?php

namespace alexshent\webapp\core;

abstract class Controller {
    protected $routeParams = [];
    
    public function __construct(array $routeParams) {
        $this->routeParams = $routeParams;
    }
    
    public function __call(string $name, array $args) {
        $method = $name . 'Action';
        
        if (!method_exists($this, $method)) {
            throw new \InvalidArgumentException("$method does not exist");
        }
        $this->before($method, $args);
        call_user_func_array([$this, $method], $args);
        $this->after($method, $args);
    }
    
    // called before action method
    protected function before(string $method, array $args) {
    }
    
    // called after action method
    protected function after(string $method, array $args) {
    }
}

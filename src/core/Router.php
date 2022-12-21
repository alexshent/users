<?php

namespace alexshent\webapp\core;

use alexshent\webapp\core\NamingConvention;

class Router {
    
    private $controllerNamespace;
    protected $routes = [];
    protected $params = [];
    
    public function __construct(string $controllerNamespace) {
        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * convert the route to a regular expresion and save into the routes array
     */
    public function add(string $route, array $params = []): void {
        // escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // convert variables
        // {controller}/{action} -> string(49) "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/i"
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // convert variables with custom regular expressions e.g. {id:\d+}
        // {controller}/{id:\d+}/{action} -> string(62) "/^(?P<controller>[a-z-]+)\/(?P<id>\d+)\/(?P<action>[a-z-]+)$/i"
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        
        // add start and end delimiters and case insensitive
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }
    
    public function getRoutes(): array {
        return $this->routes;
    }
    
    public function getParams(): array {
        return $this->params;
    }
    
    public function match(string $url): bool {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
    
    public function dispatch(string $url): void {
        if (!$this->match($url)) {
            throw new \InvalidArgumentException("no route matched");
        }
        $controller = $this->params['controller'];
        $controller = NamingConvention::hyphenToStudlyCaps($controller) . 'Controller';
        $controller = $this->getNamespace() . $controller;
        if (!class_exists($controller)) {
            throw new \InvalidArgumentException("controller class $controller not found");
        }
        $controllerObject = new $controller($this->params);
        $action = NamingConvention::hyphenToCamelCase($this->params['action']);
        if (!is_callable([$controllerObject, $action])) {
            throw new \InvalidArgumentException("method $action in controller $controller not found");
        }
        $controllerObject->$action($this->params);
    }
    
    private function getNamespace(): string {
        $namespace = $this->controllerNamespace;
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}

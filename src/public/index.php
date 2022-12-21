<?php

require __DIR__ . '/../../vendor/autoload.php';

$router = new \alexshent\webapp\core\Router('alexshent\\webapp\\application\\controllers\\');

$router->add('/', ['controller' => 'Main', 'action' => 'index']);
$router->add('/{controller}', ['action' => 'index']);
$router->add('/{controller}/{action}');

$url = $_SERVER['REQUEST_URI'];
$router->dispatch($url);

<?php

$router = new Core\Router();

// Add the routes
$router->add('/', ['controller' => 'HomeController', 'action' => 'index', 'method' => 'GET']);
$router->add('/login', ['controller' => 'UsersController', 'action' => 'login']);
$router->add('/signup', ['controller' => 'UsersController', 'action' => 'signup']);
$router->add('/register', ['controller' => 'UsersController', 'action' => 'register', 'method' => 'POST']);

$router->dispatch();
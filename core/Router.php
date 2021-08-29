<?php

namespace Core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add($route, $params = [])
    {
        $this->routes[$route] = $params;
    }

    private function match($url)
    {
        if (array_key_exists($url, $this->routes)) {
            $this->params = $this->routes[$url];
            return true;
        }
        return false;
    }

    private function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('?', $url, 2);
            if (!empty($parts[0])) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    public function dispatch()
    {
        $url = $this->removeQueryStringVariables($_SERVER['REQUEST_URI']);
        if ($this->match($url)) {
            $method = isset($this->params['method']) ? strtoupper($this->params['method']) : 'GET'; 
            if ($method !== $_SERVER['REQUEST_METHOD']) {
                throw new \Exception("Method not supported");
            }
            $controller = $this->params['controller'];
            $controller = "App\Controllers\\" . $controller;

            if (class_exists($controller)) {
                $controllerObject = new $controller($this->params);

                $action = $this->params['action'];

                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();

                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception('No route matched.', 404);
        }
    }
}
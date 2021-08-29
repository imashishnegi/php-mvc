<?php

namespace Core;

class Controller
{
    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], $args);
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    public function getParams() {
        return $_GET;
    }

    public function postParams() {
        return $_POST;
    }

    public function redirect($path) {
        header("Location: $path");
        exit;
    }
}
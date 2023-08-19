<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // return print_r($this->router->routes);
        return view('welcome_message');
    }
}

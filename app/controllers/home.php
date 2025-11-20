<?php

class Home extends Controller
{

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];
    public function index()
    {
        echo "home/index";
    }

}
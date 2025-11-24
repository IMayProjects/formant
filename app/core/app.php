<?php

$conn;

$config_file = "./../../api/config/db_config.php";

if (file_exists("./../../api/config/db_config.php")) {

    require_once '../../api/init.php';
    $conn = get_connection();
} else {
    echo "couldn't find config file";
}

class App
{
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        print_r($url);


        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        echo $this->controller;
        $this->controller = new $this->controller;

        if (method_exists($this->controller, $this->method)) {
            $this->controller->method($this->method);
        }
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}

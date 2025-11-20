<?php

class App
{
    public function __construct()
    {
        echo 'Hello<br>';
        $this->parseUrl();
    }
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            echo $_GET['url'];
        }
    }
}

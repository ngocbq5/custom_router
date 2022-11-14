<?php

namespace App\Controller;

class BaseController
{
    public function view($path, $data = [])
    {
        extract($data);
        // echo "<pre>";
        // var_dump($data);
        $path = str_replace(".", "/", $path);
        include_once(__DIR__ . "/../views/" . $path . ".php");
    }
}

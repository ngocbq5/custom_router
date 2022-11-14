<?php

namespace App;

class Router
{
    private $handlers = [];
    private $notFoundHandler;
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    //get function
    public function get($path, $handler): void
    {
        $this->addHandler(self::METHOD_GET, $path, $handler);
    }

    //post function
    public function post($path, $handler): void
    {
        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    //addHandler function
    public function addHandler($method, $path, $handler)
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function addNotFoundHandler($handler)
    {
        $this->notFoundHandler = $handler;
    }

    public function testString($str)
    {
        $len = strlen($str);
        $first_char_len = 0;
        $last_char_len = $len - 1;

        if (strpos($str, '{') !== false) {
            if (strpos($str, '}') !== false) {
                if (strpos($str, '{') == $first_char_len && strpos($str, '}') == $last_char_len) {
                    echo "$str TRUE ---<br>";
                    return true;
                }
            }
        }

        echo "$str FALSE ---<br>";
        return false;
    }
    //run function
    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];

        $method = $_SERVER['REQUEST_METHOD'];
        //lấy parameter trên URI
        $params = [];
        //Kiểm tra xem kiểu param có đúng không
        $check = true;
        $callback = null;
        foreach ($this->handlers as $handler) {
            // echo "<pre>";
            // var_dump($handler);
            // echo $requestPath;
            if ($handler['path'] === $requestPath && $method == $handler['method']) {
                $callback = $handler['handler'];
            } elseif (strpos($handler['path'], '{') !== false && strpos($handler['path'], '}') !== false) {

                $pathUri = trim($requestPath, '/');
                $pathUri = explode('/', $pathUri);
                $pathHandler = explode('/', trim($handler['path'], '/'));

                if (sizeof($pathUri) === sizeof($pathHandler)) {
                    foreach ($pathHandler as $key => $param) {
                        //echo $param . ' === ' . $pathUri[$key] . "<br>";
                        if ($param === $pathUri[$key] && $method == $handler['method']) {
                            $callback = $handler['handler'];
                            continue;
                        }
                        if (preg_match('/^{\w+}$/', $param)) {
                            $params[] = $pathUri[$key];
                        }
                    }
                }
            }
        }

        if (!$callback || $check == false) {
            header("HTTP/1.0 404 Not found");
            if (!empty($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;
                return $callback();
            }
        }

        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }

        if (is_array($callback)) {
            [$class, $method] = $callback;
            $class = new $class;
            call_user_func_array([$class, $method], $params);
        }
    }
}

<?php
class Router {
    public function start() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $url = str_replace($basePath, '', $uri);
        $url = trim($url, '/'); 

        if (empty($url)) {
            $controllerObject = new MainController();
            $controllerObject->start();
        } else {
            $controllerName = ucfirst(str_replace('-', '', $url)) . "Controller";

            if (class_exists($controllerName)) {
                $controllerObject = new $controllerName();
                $controllerObject->start();
            } else {
                http_response_code(404);
                require_once(__DIR__ . "/../views/error_404.php");
            }
        }
    }
}
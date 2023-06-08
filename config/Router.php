<?php

class Router
{
    public function handleRoutes() {

        //we import all the registered routes to handle them accordingly.
        require 'routes.php';

        //The whole request uri
        $requestUri = $_SERVER['REQUEST_URI'];

        /* 
            In debugging environment, the request uri will start with
            this path "/mvc_framework/public/" in contrast to production 
            environment. So if this part exists, we remove it.
        */
        $debuggingBasePath = "/mvc_framework/public/";

        //Once we remove the above mentioned path, we trim the path for any '/' in the end.
        $routingPath = trim(str_replace($debuggingBasePath, '', $requestUri), '/');

        //an array containing all the valid route paths.
        $validRoutes = array_keys($routes);

        //If the route exists, we trigger the corresponding method, else we render the 404 page.
        if(in_array($routingPath, $validRoutes)) {
            
            $methodArray = explode('::', $routes[$routingPath]);
            $controller = $methodArray[0];
            $method = $methodArray[1];
            
            require '../app/controllers/Home.php';

            $activeController = new $controller;

            $activeController->$method();
        }
    }
}
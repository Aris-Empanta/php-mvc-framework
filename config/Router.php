<?php

namespace Config;
use App\Controllers\_404;

class Router
{
    public function handleRoutes()
    {
        // Import all the registered routes to handle them accordingly.
        require 'routes.php';

        // The whole request URI
        $requestUri = $_SERVER['REQUEST_URI'];

        /* 
            In the debugging environment, the request URI will start with
            this path "/mvc_framework/public/" in contrast to the production 
            environment. If this part exists, we remove it.
        */
        $debuggingBasePath = "/mvc_framework/public/";

        // Once we remove the above mentioned path, we trim the path for any '/' at the end.
        $routingPath = trim(str_replace($debuggingBasePath, '', $requestUri), '/');

        // An array containing all the valid route paths.
        $validRoutes = array_keys($routes);

        // If the route exists, we trigger the corresponding method; otherwise, we render the 404 page.
        if (in_array($routingPath, $validRoutes)) {
            //We split the controller and the method
            $methodArray = explode('::', $routes[$routingPath]);
            $controller = $methodArray[0];
            $method = $methodArray[1];

            //We construct the namespace dynamically
            $controllerNamespace = 'App\\Controllers\\' . $controller; 
                        
            //we run the controllers method passing the params and query params arguments if they exist.
            $activeController = new $controllerNamespace();
            $activeController->$method();
        } else {
            // Check if the routing path matches a route with parameters
            foreach ($validRoutes as $validRoute) {
                //We establish a regex pattern that matches the route if it has params
                $pattern = $this->getRoutePattern($validRoute);

                //if the route has params
                if ($this->matchesPattern($routingPath, $pattern)) {
                    //We split the controller and the method
                    $methodArray = explode('::', $routes[$validRoute]);
                    $controller = $methodArray[0];
                    $method = $methodArray[1];

                    //We extract the params or the query params
                    $params = $this->extractParams($routingPath, $pattern);
                    $queryParams = $this->extractQueryParams();
                    
                    //We construct the namespace dynamically
                    $controllerNamespace = 'App\\Controllers\\' . $controller; 
                        
                    //we run the controllers method passing the params and query params arguments if they exist.
                    $activeController = new $controllerNamespace();
                    $args = array_merge($params, [$queryParams]);
                    $activeController->$method(...$args);
                    
                    // Stop processing further routes
                    return; 
                }
            }
            
            $_404 = new _404;

            $_404->index();
        }
    }

    //The pattern of a route that contains params
    private function getRoutePattern($route)
    {
        $pattern = preg_replace('/{(\w+)}/', '(?P<$1>[^/]+)', $route);
        return "#^$pattern$#";
    }

    //the method to check if a route matches a regex patter.
    private function matchesPattern($path, $pattern)
    {
        return preg_match($pattern, $path);
    }

    //The method to extract params array
    private function extractParams($path, $pattern)
    {
        preg_match($pattern, $path, $matches);
        unset($matches[0]); // Remove the full match
        return array_values($matches);
    }

    //The method to extract query params array
    private function extractQueryParams()
    {
        $queryParams = [];

        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $queryParams);
        }

        return $queryParams;
    }
}
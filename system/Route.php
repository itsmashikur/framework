<?php

// class Route
// {
//     public static $routes = [];


//     public static function get($route, $handler)
//     {
//         self::$routes['GET'][$route] = $handler;
//     }

//     public static function post($route, $handler)
//     {
//         self::$routes['POST'][$route] = $handler;
//     }

//     public static function run()
//     {
//         $requestMethod = $_SERVER['REQUEST_METHOD'];

//         $route = explode('?', $_SERVER['REQUEST_URI'])[0];
//         if (!isset(self::$routes[$requestMethod])) {
//             self::$routes[$requestMethod] = array();
//         }
//         try {


//             $handler = self::getMatchedRouteHandler($route, $requestMethod);
//             $parameters   = $handler['parameters'] ?? null;
//             $routeHandler = $handler['handler']    ?? null;
            
//             if ($routeHandler) {
//                 list($controller, $method) = explode('@', $routeHandler);
//                 if (class_exists($controller)) {
//                     if (method_exists($controller, $method)) {
//                         $request = new Request($parameters);
//                         (new $controller)->$method($request);
//                     } else {
//                         throw new Exception('Method not found.',404);
//                     }
//                 } else {
//                     throw new Exception('Controller not found.',404);
//                 }
//             } else {
//                 throw new Exception('Route not found.',404);
//             }
//         } catch (Exception $e) {
//             $errorController = new ErrorHandler();
//             $errorController->handle($e->getCode(), $e->getMessage());
//         }
//     }

//     private static function getMatchedRouteHandler($route, $requestMethod)
//     {
//         $routeHandlers = self::$routes[$requestMethod];
//         foreach ($routeHandlers as $routePattern => $routeHandler) {
//             $routeRegex = self::getRouteRegex($routePattern);
//             if (preg_match($routeRegex, $route, $matches)) {
//                 $parameters = array();
//                 $route = $routePattern;
//                 $url = array_shift($matches);
//                 $pattern = "#^" . str_replace(array('{', '}'), array('(?P<', '>\w+)'), $route) . "$#";
//                 if (preg_match($pattern, $url, $matches)) {
//                     foreach ($matches as $key => $value) {
//                         if (is_string($key)) {
//                             $parameters[$key] = $value;
//                         }
//                     }
//                 } else {
//                     $errorController = new ErrorHandler();
//                     return $errorController->handle(404, "URL does not match pattern");
//                 }
//                 return ['handler' => $routeHandler, 'parameters' => $parameters];
//             }
//         }
//         return false;
//     }

//     private static function getRouteRegex($routeRegex)
//     {
//         preg_match_all('/\{(\w+)\}/', $routeRegex, $matches);
//         for ($i = 0; $i < count($matches[0]); $i++) {
//             $param = $matches[1][$i];
//             $routeRegex = str_replace('{' . $param . '}', '(\w+)', $routeRegex);
//         }
//         return '#^' . $routeRegex . '$#';
//     }

// }



class Route
{
    private static $routes = [];
    private static $groupPrefix = '';

    public static function group($prefix, $callback)
    {
        $previousGroupPrefix = self::$groupPrefix;
        self::$groupPrefix .= $prefix;
        $callback();
        self::$groupPrefix = $previousGroupPrefix;
    }

    public static function get($route, $handler)
    {
        self::addRoute('GET', $route, $handler);
    }

    public static function post($route, $handler)
    {
        self::addRoute('POST', $route, $handler);
    }

    public static function run()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $route = explode('?', $_SERVER['REQUEST_URI'])[0];
        if (!isset(self::$routes[$requestMethod])) {
            self::$routes[$requestMethod] = array();
        }
        try {
            $handler = self::getMatchedRouteHandler($route, $requestMethod);
            $parameters   = $handler['parameters'] ?? null;
            $routeHandler = $handler['handler']    ?? null;

            if ($routeHandler) {
                list($controller, $method) = explode('@', $routeHandler);
                if (class_exists($controller)) {
                    if (method_exists($controller, $method)) {
                        $request = new Request($parameters);
                        (new $controller)->$method($request);
                    } else {
                        throw new Exception('Method not found.',404);
                    }
                } else {
                    throw new Exception('Controller not found.',404);
                }
            } else {
                throw new Exception('Route not found.',404);
            }
        } catch (Exception $e) {
            $errorController = new ErrorHandler();
            $errorController->handle($e->getCode(), $e->getMessage());
        }
    }

    private static function addRoute($method, $route, $handler)
    {
        $route = self::$groupPrefix . $route;
        self::$routes[$method][$route] = $handler;
    }

    private static function getMatchedRouteHandler($route, $requestMethod)
    {
        $routeHandlers = self::$routes[$requestMethod];
        foreach ($routeHandlers as $routePattern => $routeHandler) {
            $routeRegex = self::getRouteRegex($routePattern);
            if (preg_match($routeRegex, $route, $matches)) {
                $parameters = array();
                $route = $routePattern;
                $url = array_shift($matches);
                $pattern = "#^" . str_replace(array('{', '}'), array('(?P<', '>\w+)'), $route) . "$#";
                if (preg_match($pattern, $url, $matches)) {
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $parameters[$key] = $value;
                        }
                    }
                } else {
                    $errorController = new ErrorHandler();
                    return $errorController->handle(404, "URL does not match pattern");
                }
                return ['handler' => $routeHandler, 'parameters' => $parameters];
            }
        }
        return false;
    }

    private static function getRouteRegex($routeRegex)
    {
        // find all parameters in the route regex
        preg_match_all('/\{(\w+)\}/', $routeRegex, $matches);
    
        // replace each parameter with a named capture group in the regex
        for ($i = 0; $i < count($matches[0]); $i++) {
            $param = $matches[1][$i];
            $routeRegex = str_replace('{' . $param . '}', '(?P<' . $param . '>\w+)', $routeRegex);
        }
    
        // add start and end anchors to the regex
        $routeRegex = '#^' . $routeRegex . '$#';
    
        return $routeRegex;
    }

}
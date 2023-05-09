<?php


namespace MyApp\System\Modules\Route;

use MyApp\Routers\Web;
use MyApp\System\Interfaces\IConfig;
use MyApp\System\Interfaces\IWeb;

class Route {

    private static $listRoutes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => []
    ];

 
    static function prepareRoute(string $url) {
        $arrayUrl = explode('/', $url);
        $arrayUrlPrepared =  array_map(function($value) {
            if( strpos($value, '}') !== false ) {
                return "\w+";
            }
            return $value;
        }, $arrayUrl);

        return implode("\/",$arrayUrlPrepared);
    } 

    static public function get(string $route, array $controllerAndMethod, array $middlewares = []):void {
        self::addRoute('GET' ,  $route, $controllerAndMethod,  $middlewares);
       
    }

    static public function post(string $route, array $controllerAndMethod, array $middlewares = []):void {
        self::addRoute('POST' ,  $route, $controllerAndMethod,  $middlewares);
    }
    
    static public function put(string $route, array $controllerAndMethod, array $middlewares = []):void {
        self::addRoute('PUT' ,  $route, $controllerAndMethod,  $middlewares);
    }

    static public function delete(string $route, array $controllerAndMethod, array $middlewares = []):void {
        self::addRoute('DELETE' ,  $route, $controllerAndMethod,  $middlewares);
    }


    private static function addRoute(string $verbHttp , string $url, array $controllerAndMethod, array $middlewares = []):void {
        $route = self::prepareRoute($url);
        self::$listRoutes[$verbHttp][$route] = [
            'url' => $url,
            'controllerAndMethod' => $controllerAndMethod,
            'middlewares' => $middlewares
        ];
    }


    public static function list():array {
        return self::$listRoutes;
    }



    public function existUrl(string $url, string $method) {
        foreach (self::$listRoutes[$method] as $route => $dadosRoute) {
            if (preg_match("/^".$route."$/" ,  $url)) {
                return true;
            }
        } 
        return false;
    }


    public function action(string $url, string $method) {
        foreach (self::$listRoutes[$method] as $route => $dadosRoute) {
            if (preg_match("/^".$route."$/" ,  $url)) {

                return call_user_func($dadosRoute['controllerAndMethod'], new Request(), new Response());
            }
        } 
    }
}
<?php


namespace MyApp\System\Modules\Route;

use MyApp\Routers\Web;
use MyApp\System\Interfaces\IConfig;
use MyApp\System\Interfaces\IWeb;
use MyApp\System\Modules\Config\Config;

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

    static public function get(string $route, array $controllerAndMethod):void {
        self::addRoute('GET' ,  $route, $controllerAndMethod);
       
    }

    static public function post(string $route, array $controllerAndMethod):void {
        self::addRoute('POST' ,  $route, $controllerAndMethod);
    }
    
    static public function put(string $route, array $controllerAndMethod):void {
        self::addRoute('PUT' ,  $route, $controllerAndMethod);
    }

    static public function delete(string $route, array $controllerAndMethod):void {
        self::addRoute('DELETE' ,  $route, $controllerAndMethod);
    }


    private static function addRoute(string $verbHttp , string $url, array $controllerAndMethod):void {
        $config = new Config();
        $route = $config->get('HOST'). self::prepareRoute($url);
        self::$listRoutes[$verbHttp][$route] = [
            'url' => $url,
            'controllerAndMethod' => $controllerAndMethod
        ];
    }


    private static function getParamUrl(string $urlController, string $urlRequest) {
        $pathArray = explode('/', $urlRequest);
        $arrayUrl = explode('/', $urlController);
        $arrayUrlPrepared = [];
        foreach ($arrayUrl as $index => $value) {
            if (strpos($value, '}') !== false) {
                $value = str_replace('{', '', $value);
                $value = str_replace('}', '', $value);
                $arrayUrlPrepared[$value] = $pathArray[$index];
            }
        }

        return $arrayUrlPrepared;
    }

    public static function list():array {
        return self::$listRoutes;
    }



    public function existUrl(string $url, string $verbHttp) {
        foreach (self::$listRoutes[$verbHttp] as $route => $dadosRoute) {
            if (preg_match("/^".$route."$/" ,  $url)) {
                return true;
            }
        } 
        return false;
    }


    public function action(string $url, string $verbHttp) {
        $data = [];
        foreach (self::$listRoutes[$verbHttp] as $route => $dadosRoute) {
            if (preg_match("/^".$route."$/" ,  $url)) {
                if( $verbHttp == 'GET') {
                    $routeRegister = $dadosRoute['url'];
                    $data = self::getParamUrl($routeRegister,$url);
                }
                return call_user_func($dadosRoute['controllerAndMethod'], new Request(), new Response(), $data);
            }
        } 
    }
}
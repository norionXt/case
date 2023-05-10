<?php
namespace MyApp;
/*
$colors = array("red", "green", "blue", "yellow");


function p($c, &$next) {
    echo $c."\n";
    if (  $c !== false) {
        p(next($next), $next);
    }
}

// move o ponteiro do cursor para o próximo elemento
//p(current($colors), $colors);


class teste {
    
    private static $list = [];

    function __construct($res) {

        $l = current(self::$list)($res);
        if($l !== false ) {
            return next(self::$list)($l);
        }
        return $l;
    }

    static function setList($l) {
        self::$list = $l;
    }

    
}


class Te {
    static function handle($res) {
        echo $res;
    }
}


teste::setList([
    [Te::class, 'handle'],
    [Te::class, 'handle'],
]);


new teste(12);*/
/*$regex = '/^localhost\/\w+\/\w+$/';
$url = 'localhost/casa/65';
$router = 'localhost/{movel}/{id}';

$dados = [];
if (preg_match($regex, $url)) {
   $urlList = explode('/', $url);
   $routeList = explode('/', $router);
    foreach ($routeList as $index => $route) {
        if(strpos($route, '{') !== false) {
            $route = str_replace('{','',$route);
            $route = str_replace('}','',$route);
            $dados[$route] = $urlList[$index];                  
        }
    }

} else {
    // a string não passou na validação
}


*/



$url = 'localhost/{casa}/{id}';
$pathArray = explode('/','localhost/apartamento/1');
$arrayUrl = explode('/', $url);
$arrayUrlPrepared = [];
foreach ($arrayUrl as $index => $value) {

    if( strpos($value, '}') !== false ) {
        $value = str_replace('{','',$value);
        $value = str_replace('}', '', $value);
        $arrayUrlPrepared[$value] = $pathArray[$index];
    }
}

echo var_dump($arrayUrlPrepared);

/*

        $config = new Config();
        $url = "{$config->get('url')}/{id}/{casa}/params";
        $route = new Route($config);
        $route::get($url,[]);
        $result = $route->existUrl($url, 'get');


class Config{

    function __construct()
    {
        $this->loadConfig(dirname(__DIR__,4).'\.env');
    }

    private function loadConfig(string $pathFile) {
        $handle = fopen($pathFile,'r');
        
        if( $handle ) {
            while (($line = fgets($handle)) !== false) {
                $this->get($line);
            }

            fclose($handle);
        }
    }

    function get(string $config) {
        return getenv($config);
    }

    function put(string $config, string $value) {
        return putenv("{$config}={$value}");
    }
}



class Route {

    private static $listRoutes = [
        'get'    => [],
        'post'   => [],
        'put'    => [],
        'delete' => []
    ];

    private static string $url;

    function __construct($config)
    {
        self::$url =  $config->get('url');
        echo $config->get('url').'a';
    }

    static function prepareRoute(string $url) {
        $arrayUrl = explode('/', $url);
        $arrayUrlPrepared =  array_map(function($value) {
            if( strpos($value, '}') !== false ) {
                return '\/w+';
            }
            return $value;
        }, $arrayUrl);

        return implode("/",$arrayUrlPrepared);
    } 

    static public function get(string $route, array $controllerAndMethod, array $middlewares = null):void {
        $route = self::$url.self::prepareRoute($route);
        self::$listRoutes['get'][$route] = [
            'controller' => $controllerAndMethod[0],
            'method' => $controllerAndMethod[1],
            'middlewares' => $middlewares
        ];
    }

    static public function post(string $route, array $controllerAndMethod, array $middlewares = null):void {
        $route = self::$url.self::prepareRoute($route);
        self::$listRoutes['post'][$route] = [
            'controller' => $controllerAndMethod[0],
            'method' => $controllerAndMethod[1],
            'middlewares' => $middlewares
        ];
    }
    
    static public function put(string $route, array $controllerAndMethod, array $middlewares = null):void {
        $route = self::$url.self::prepareRoute($route);
        self::$listRoutes['put'][$route] = [
            'controller' => $controllerAndMethod[0],
            'method' => $controllerAndMethod[1],
            'middlewares' => $middlewares
        ];
    }

    static public function delete(string $route, array $controllerAndMethod, array $middlewares = null):void {
        $route = self::$url.self::prepareRoute($route);
        self::$listRoutes['delete'][$route] = [
            'controller' => $controllerAndMethod[0],
            'method' => $controllerAndMethod[1],
            'middlewares' => $middlewares
        ];
    }




    public function existUrl(string $url, string $method) {

        foreach (self::$listRoutes[$method] as $route => $dadosRoute) {
            if (preg_match($route, $url)) {
                return true;
            }
        } 

        return false;


    }
}*/
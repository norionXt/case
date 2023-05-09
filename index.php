<?php

use MyApp\Routers\Web;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Route\Request;
use MyApp\System\Modules\Route\Response;
use MyApp\System\Modules\Route\Route;

require "vendor/autoload.php";

$request = new Request();
$config = new Config();
$route = new Route($config);
Web::loadRoutes();

if($route->existUrl($request->url(), $request->method())) {
    $route->action($request->url(), $request->method());
} else {
    $response = new Response();
    $response->sendJson(['error'=> '200', 'message' => "rota não existe"]);
}
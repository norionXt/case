<?php

use MyApp\System\Interfaces\IConfig;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Route\Request;
use MyApp\System\Modules\Route\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase{

    private IConfig $config;
    private string $domainUrl;
    

    function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name,$data,$dataName);
        $this->config = new Config();
        $this->domainUrl = $this->config->get('domain');
    }

    function testPreparedRoute() {

        $result = Route::prepareRoute("{$this->domainUrl}/{id}");
        $this->assertSame("{$this->domainUrl}\/\w+" ,$result);

        $result = Route::prepareRoute("{$this->domainUrl}/{id}/{casa}");
        $this->assertSame("{$this->domainUrl}\/\w+\/\w+" ,$result);

        $result = Route::prepareRoute("{$this->domainUrl}/{id}/{casa}/params");
        $this->assertSame("{$this->domainUrl}\/\w+\/\w+\/params" ,$result);        
    }


    function testRouteExist() {
        $route = new Route($this->config);

        $paths = [
            "{id}/{casa}/params" => '2/apt/params',
            "params/teste/{id}" => 'params/teste/25',
            "params/{id}/teste" => 'params/50/teste',
            "params/{id}/teste/{valor}" => 'params/50/teste/outrovalor',
        ];

        $verbsHttp = ['get','post','put','delete'];

        foreach ($verbsHttp as $verb) {
            foreach ($paths as $routeController => $routeRequest) {
                $route::{$verb}($routeController,[]);
                $result = $route->existUrl($routeRequest, $verb);
                $this->assertTrue($result);
            }
        }      
    }

}
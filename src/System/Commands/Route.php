<?php
namespace MyApp\System\Commands;

use MyApp\Routers\Web;
use MyApp\System\Interfaces\ICommands;
use MyApp\System\Modules\Route\Route as RouteRoute;
use MyApp\System\Traits\Menssage;

class Route implements ICommands {

    use Menssage;

    private const TOTAL_SPACE = 25;

    function help() {
        return  $this->addTextInGreen("Route:
    Usage: php artisan route [opções]

        !{help}!          Exibe esta mensagem de ajuda do módulo
        !{list}!          Exibe a listagem das rotas da aplicação");
    }

    function list() {
        $listRoutes = [];
        $report = '';
        Web::loadRoutes();
        foreach (RouteRoute::list() as $verb => $listRoutes) {
            foreach ($listRoutes as $route) {
                $verb = strtoupper($verb);
                $controller = $route['controllerAndMethod'][0];
                $method = $route['controllerAndMethod'][1];                
                $report .= "\n!{{$verb}}!  {$route['url']} ....................... {$controller}:{$method}";
            }
        }
        echo $this->addTextInGreen($report);
    }


}
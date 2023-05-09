<?php

namespace MyApp\System\Commands;

use Exception;
use ICommands;
use MyApp\System\Interfaces\ICommands as InterfacesICommands;
use MyApp\System\Traits\Menssage;
use MyApp\System\Traits\Template;

class Controller  implements InterfacesICommands{
    use Menssage, Template;


    function help() {
        return $this->addTextInGreen("Controller:
    Usage: php artisan controller [ação] [parâmetros]

          !{help}!          Exibe esta mensagem de ajuda
          !{api}!  <nome do controller>   cria uma classe de controller
                exemplo: php artisan controller api nomeClass");
    }


    function api(array $params = []) {
        if(count($params) === 0) {
            return throw new Exception('O nome do controller não foi passado.');
        }
        $nameClass = $params[0];
        $this->createTemplate($nameClass, 'ApiController','Controller');


    }
}


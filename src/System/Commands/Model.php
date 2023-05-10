<?php

namespace MyApp\System\Commands;

use Exception;
use MyApp\System\Interfaces\ICommands as InterfacesICommands;
use MyApp\System\Traits\Menssage;
use MyApp\System\Traits\Template;

class Model  implements InterfacesICommands{
    use Menssage, Template;


    function help() {
        return $this->addTextInGreen("Model:
    Usage: php artisan model [ação] [parâmetros]

          !{help}!          Exibe esta mensagem de ajuda
          !{create}!  <nome do Model>   cria uma classe de Model
                exemplo: php artisan Model create nomeClass");
    }


    function create(array $params = []) {
        if(count($params) === 0) {
            return throw new Exception('O nome do model não foi passado.');
        }
        $nameClass = $params[0];
        $this->createTemplate($nameClass, 'Model','Model');


    }
}


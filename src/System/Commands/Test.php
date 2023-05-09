<?php

namespace MyApp\System\Commands;

use MyApp\System\Interfaces\ICommands as InterfacesICommands;
use MyApp\System\Traits\Menssage;

class Test  implements InterfacesICommands{
    use Menssage;
    function help() {
        $textHelp = $this->start(['--help']);
        $textHelp = str_replace('phpunit', 'artisan test start', $textHelp);
        $textHelp = str_replace('UnitTest.php', '', $textHelp);
        $textHelp = str_replace('<directory>', '', $textHelp);
        $textHelp = str_replace('<file>', '', $textHelp);
        $textHelp = str_replace('<dir>', '', $textHelp);        
        return $textHelp;
    }

    function start(array $params) {
        $output = [];
        $paramsLine =  implode(' ',$params);
        exec("php ./vendor/bin/phpunit {$paramsLine} test",$output);
        return implode("\n", $output);
    }

}


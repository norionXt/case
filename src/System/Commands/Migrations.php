<?php
namespace MyApp\System\Commands;

use MyApp\System\Interfaces\ICommands;
use MyApp\System\Interfaces\IDB;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Migrations\Table;
use MyApp\System\Traits\GetClassDir;
use MyApp\System\Traits\Menssage;
use MyApp\System\Traits\Template;

class Migrations implements  ICommands {
    use Menssage, Template, GetClassDir;

    function help() {
        return $this->addTextInGreen(" Migrations:
    Usage: php artisan migrations [ação] [opção]

        !{help}!      exibe a lista de comandos do Migration
        !{create}!    <nome da migration>  cria arquivo de migração
        !{up}!        cria as tabelas no banco de dados
        "); 
    }


    function create(array $params) {
        $nameClass = $params[0];
        $this->createTemplate($nameClass, 'Migrations', 'Migrations');
    }


    function up() {
        $path = dirname(__DIR__,2)."/Migrations";
        $database = $this->getDatabase();
        foreach ($this->getClass($path) as $file) {
            $class = "MyApp\\Migrations\\{$file}";
            $table = (new $class())->up(new Table());
            $database->query($table,[]) ;
        }

        return $this->addTextInGreen("
        !{Tabelas criadas com sucesso}!
        ");
    }

    private function getDatabase():IDB {
        $config = new Config();
        $database = $config->get('DB_CONNECTION');
        $database =  "MyApp\\System\\Modules\\Databases\\".ucfirst($database);
        return new $database($config);
    }

}
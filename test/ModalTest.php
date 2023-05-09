<?php

use MyApp\Modal\Usuarios;
use MyApp\System\Interfaces\IDB;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Databases\Mysql;
use MyApp\System\Modules\Modal\Query;
use PHPUnit\Framework\TestCase;

final class ModalTest extends TestCase{

    private IDB $connectDatabase;
 
    function setUp(): void
    {
        $config = new Config();
        $this->connectDatabase = new Mysql($config);
    }
 
    function QueryInsert() {


        $modal = new Usuarios($this->connectDatabase, new Query());
        $user = [
            'nomeCompleto' => 'fernando',
            'email' => 'fernando@gmail.com',
            'cpf'   => '777.777.77-25',
            'senha' => '4651261'

        ];

        $modal->insert($user);

    }




    
    function testQueryWhereSelect() {


        $modal = new Usuarios($this->connectDatabase, new Query());

        echo var_dump($modal->where('id','=','1')->select(['nomeCompleto']));

    }

}
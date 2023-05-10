<?php

use MyApp\Model\Payment;
use MyApp\Model\Usuarios;
use MyApp\System\Interfaces\IDB;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Databases\Mysql;
use MyApp\System\Modules\Fetch\Fetch;
use MyApp\System\Modules\Model\Query;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase{

    private IDB $connectDatabase;
 
    function setUp(): void
    {
        $config = new Config();
        $this->connectDatabase = new Mysql($config);
    }
 
    function testQueryInsert() {
        $pay = new Payment();
      $res =  $pay->transfer(56,6,15);
      echo var_dump($res);
    }




    
    function testQueryWhereSelect() {


        $Model = new Usuarios($this->connectDatabase, new Query());

        echo var_dump($Model->where('id','=','1')->select(['nomeCompleto']));

    }


    function testFetch() {


    }
}
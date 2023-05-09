<?php

namespace MyApp\System\Modules\Databases;

use MyApp\System\Interfaces\IConfig;
use MyApp\System\Interfaces\IDB;
use PDO;

class Mysql implements IDB{

    private $database;
    private $config;

    function __construct(IConfig $config)
    {
        $this->config = $config;
        $this->connect();
    }

    function connect() {
        $host = $this->config->get('DB_HOST');
        $dbname = $this->config->get('DB_DATABASE');
        $port = $this->config->get('DB_PORT');
        $user = $this->config->get('DB_USERNAME');
        $password = $this->config->get('DB_PASSWORD');
        $this->database = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $password);
    }

    function query(string $query, array $dados = []){
        $queryPrepared = $this->database->prepare($query);
        $queryPrepared->execute($dados);
        return $queryPrepared->fetch(PDO::FETCH_ASSOC);
    }
}
<?php

namespace MyApp\System\Modules\Modal;

use MyApp\System\Interfaces\IDB;
use MyApp\System\Interfaces\IModal;
use MyApp\System\Interfaces\IQuery;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Databases\Mysql;

class Modal implements IModal {


    private IDB $database;
    private IQuery $query;
    private array $dados = [];

    function __construct()
    {
        $config = new Config();
        $this->query = new Query();
        $nameDB = $config->get('DB_CONNECTION'); 
        $pathDatabase = "MyApp\System\Modules\Databases\\".ucfirst($nameDB);
        $this->database = new $pathDatabase($config);
    }

    public function select(array $dados){
       $arrayNamespace = explode("\\",get_class($this));
       $nameTable = end($arrayNamespace);
       $query = $this->query->table($nameTable)->select($dados);
       return $this->database->query($query, $this->dados);
    }


    public function insert(array $columnsValue){
        $arrayNamespace = explode("\\",get_class($this));
        $nameTable = end($arrayNamespace);
        $columns = array_keys($columnsValue);
        $query = $this->query->table($nameTable)->insert($columns);
        return $this->database->query($query, $this->preparedDados($columnsValue));
    }

    public function where(string $column, string $condition ,string $value){
        $this->query->where($column, $condition);
        $this->dados[":{$column}"] = $value;
        return $this;
    }

    private function preparedDados(array $columnsValue) {
        $newColumns =[];
        foreach (array_keys($columnsValue) as $column) {
            $newColumns[":{$column}"] = $columnsValue[$column];
        }
        return $newColumns;
    }

}
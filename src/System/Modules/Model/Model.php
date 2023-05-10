<?php

namespace MyApp\System\Modules\Model;

use MyApp\System\Interfaces\IDB;
use MyApp\System\Interfaces\IModel;
use MyApp\System\Interfaces\IQuery;
use MyApp\System\Modules\Config\Config;
use MyApp\System\Modules\Databases\Mysql;

class Model implements IModel {


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
       $this->query->clear();
       return $this->database->query($query, $this->dados);
    }


    public function insert(array $columnsValue){
        $arrayNamespace = explode("\\",get_class($this));
        $nameTable = end($arrayNamespace);
        $columns = array_keys($columnsValue);
        $query = $this->query->table($nameTable)->insert($columns);
        $this->query->clear();
        return $this->database->query($query, $this->preparedDados($columnsValue));
    }

    public function where(string $column, string $condition ,string $value, string $conditionSeg = ''){
        $this->query->where($column, $condition, $conditionSeg);
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


    public function query(string $query, array $columnsValue = [])
    {
        return $this->database->query($query, $this->preparedDados($columnsValue));
    }

}
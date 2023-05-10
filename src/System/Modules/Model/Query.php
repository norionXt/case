<?php

namespace MyApp\System\Modules\Model;

use MyApp\System\Interfaces\IQuery;

class Query implements IQuery {

    private string $where ='';
    private string $table ='';    

    public function select(array $columns) {
        $columns = implode(',', $columns);
        $this->where = strlen($this->where) > 0 ? ' where '.$this->where: '';
        return "select {$columns} from {$this->table} {$this->where}";
    } 

    public function table( string $table) {
        $this->table = $table;
        return $this;
    }

    public function update(array $columns) {
        $columns = array_map(function($column) {
            return "{$column}=:{$column}";
        }, $columns);

        $columns = implode(',', $columns);
        return "update {$this->table} set {$columns},date_updated=now() where {$this->where}";
    } 


    public function where(string $column,string $condition, string $segCondition = '') {
        $this->where .= "{$column}{$condition}:{$column} {$segCondition} ";
        return $this;
    } 

    public function insert(array $columns) {
        $columnsTable = implode(',', $columns);
        $columnsValue = array_map(function($column) {
            return ":{$column}";
        }, $columns);
        $columnsValue = implode(',', $columnsValue);
        return "insert into {$this->table}  ({$columnsTable}) values ({$columnsValue})";
    } 


    public function clear() {
        $this->where ='';
        $this->table ='';
    }


    public function createDatabase(string $dbname) {
        return "CREATE DATABASE IF NOT EXISTS {$dbname}";
    }     
}
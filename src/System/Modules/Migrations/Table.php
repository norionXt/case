<?php

namespace MyApp\System\Modules\Migrations;

use MyApp\System\Interfaces\IColumn;
use MyApp\System\Interfaces\ITable;

class Table implements ITable{

    private array $columns = [];
    private string $nameTable = '';

    function __toString()
    {
        $query  = array_map( function(IColumn $column) {
            return $column->query();
        }, $this->columns);

        $queryCreateTable = "create table IF NOT EXISTS {$this->nameTable}  (". implode(',', $query).") ENGINE=InnoDB";
        return $queryCreateTable;
    }


    public function name(string $nameTable){
        $this->nameTable = $nameTable;
    }
    
    public function id(){
        $column = new Column();
        array_push($this->columns, $column->id());
    }

    public function string(string $nameColumn){
        $column = new Column();
        array_push($this->columns, $column);
        return $column->string($nameColumn);
    }

    public function default($value){
        $column = end($this->columns);
        $column->default($value);
        reset($this->columns);
        return $this;
    }


    public function decimal(string $nameColumn){
        $column = new Column();        
        array_push($this->columns, $column->decimal($nameColumn));
        return $this;
    }


    public function unique() {
        $column = end($this->columns);
        $column->unique();
        reset($this->columns);
        return $this;
    }

}
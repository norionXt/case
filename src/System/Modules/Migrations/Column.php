<?php

namespace MyApp\System\Modules\Migrations;

use MyApp\System\Interfaces\IColumn;

class Column implements IColumn {

    private $attributes = [];

    function query()
    {
        return implode('', $this->attributes);
    }

    public function unsigned(){
        array_push($this->attributes, ' unsigned');
        return $this;        
    }




    public function string(string $column){
        $this->attributes[0] = $column;
        $this->attributes[1] = ' varchar(255) ';
        return $this;
    }

    public function decimal(string $column) {
        $this->attributes[0] = $column;
        $this->attributes[1] = ' decimal ';
        return $this;        
    }

    public function notNull(){
        array_push($this->attributes, ' not null ');
        return $this;        
    }

    public function unique(){
        array_push($this->attributes, ' unique ');
        return $this;        
    }


    public function default($value){
        array_push($this->attributes, " default {$value}");
        return $this;        
    }

    public function id() {
        array_push($this->attributes, 'id bigint unsigned auto_increment primary key ');
        return $this;
    }


}
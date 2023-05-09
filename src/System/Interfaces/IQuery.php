<?php

namespace MyApp\System\Interfaces;

interface IQuery {
    public function select(array $columns);
    public function insert(array $columns);    
    public function table( string $table);
    public function update(array $columns);
    public function where(string $column,string $condition, string $segCondition ='');
}
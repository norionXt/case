<?php

namespace MyApp\System\Interfaces;

interface IModel {
    public function select(array $columns);    
    public function insert(array $columnsValue);
    public function where(string $column, string $condition,string $value);
    public function query(string $query, array $columnsValue);
}
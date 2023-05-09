<?php

namespace MyApp\System\Interfaces;

interface IModal {
    public function select(array $columns);    
    public function insert(array $columnsValue);
    public function where(string $column, string $condition,string $value);
}
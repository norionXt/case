<?php


namespace MyApp\System\Interfaces;


interface IColumn {
    public function unsigned();
    public function decimal(string $column);
    public function string(string $column);
    public function notNull();
    public function query();
}
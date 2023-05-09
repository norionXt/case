<?php


namespace MyApp\System\Interfaces;


interface ITable {
    public function name(string $nameTable);
    public function id();
    public function string(string $text);
    public function decimal(string $column);
}
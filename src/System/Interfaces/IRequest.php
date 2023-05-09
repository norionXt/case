<?php


namespace MyApp\System\Interfaces;


interface IRequest {
    public function query(string $query): string;    
    public function input(string $param): string;
    public function method(): string;
    public function header(string $head, string $default): string;
}
<?php


namespace MyApp\System\Interfaces;

interface IDB {
     public function connect();
     public function query(string $query, array $dados);    
}
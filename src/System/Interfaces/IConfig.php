<?php


namespace MyApp\System\Interfaces;

interface IConfig {
     public function get(string $config);
     public function put(string $config);    
}
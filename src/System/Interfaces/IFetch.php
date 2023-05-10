<?php


namespace MyApp\System\Interfaces;


interface IFetch {
    public function get(string $url);
    public function post(string $url, array $data);    
}
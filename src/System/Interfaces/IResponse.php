<?php


namespace MyApp\System\Interfaces;


interface IResponse {
    public function send(string $text);
    public function header(string $header);
    public function status(int $code);    
    public function sendJson(array $params);
}
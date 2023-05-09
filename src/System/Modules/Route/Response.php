<?php


namespace MyApp\System\Modules\Route;

use MyApp\System\Interfaces\IResponse;

class Response implements IResponse {

    private $header = [];
    
    public function send(string $text){
        header( implode('',$this->header) );
        echo $text;
    }

    public function header(string $header){
        array_push($this->header, $header);
        return $this;
    }

    public function status(int $code) {
        http_response_code($code);
        return $this;
    }

    public function sendJson(array $params){
        header('Content-Type: application/json');
        echo json_encode($params);
    }

}
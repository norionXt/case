<?php


namespace MyApp\System\Modules\Route;

use MyApp\System\Interfaces\IRequest;
use MyApp\System\Traits\HeaderRequest;

class Request implements IRequest{
use HeaderRequest;

    public function query(string $param): string {
        return isset($_GET[$param]) ? $_GET[$param]: false;
    }

    public function input(string $param): string {
        if($this->method() === "PUT") {
            return $this->getPut($param);
        }
        return isset($_POST[$param]) ? $_POST[$param]: false;
    }
    public function method(): string{
        return $_SERVER['REQUEST_METHOD'];
    }
    public function header(string $head, string $default = ''): string {
        $headers = $this->getallheaders(); 
        return isset($headers[$head]) ? $headers[$head]: $default;
    }

    private function getPut($name) {
        $putData = file_get_contents('php://input');
        $dados = json_decode($putData, true);
        return isset($dados[$name])? $dados[$name]:false;
    } 

    public function url() {
        return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
}
<?php


namespace MyApp\System\Modules\Route;

use MyApp\System\Interfaces\IRequest;
use MyApp\System\Traits\HeaderRequest;

class Request implements IRequest{
use HeaderRequest;

    public function query(string $param): string {
        return isset($_GET[$param]) ? $_POST[$param]: false;
    }

    public function input(string $param): string {
        return isset($_POST[$param]) ? $_POST[$param]: false;
    }
    public function method(): string{
        return $_SERVER['REQUEST_METHOD'];
    }
    public function header(string $head, string $default = ''): string {
        $headers = $this->getallheaders(); 
        return isset($headers[$head]) ? $headers[$head]: $default;
    }

    public function url() {
        return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
}
<?php

namespace MyApp\System\Commands;

use MyApp\System\Exceptions\Message;

class Commands {

    private $classCommand;
    private $methodCommand = '';
    private $paramsMethodCommand = [];

    function params(array $arg) {
        $this->paramsMethodCommand= $arg;
        return $this;
    }

    function method(string $method) {
        $this->methodCommand = $method;
        return $this;        
    }

    function command(string $command) {
        $class = "MyApp\System\Commands\\".$command;
        
        if(!class_exists($class)) {
            throw new Message(" Comando não existe\n use as opção --help para ver a lista de opções");
        }
        
        $this->classCommand = new $class();
        return $this;
    }

    function execute() {
        if(empty($this->methodCommand)) {
            return $this->classCommand;
        }

        if(method_exists($this->classCommand::class, $this->methodCommand)) {
            return call_user_func([$this->classCommand, $this->methodCommand], $this->paramsMethodCommand);
        }


    }
}
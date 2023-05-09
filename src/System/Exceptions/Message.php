<?php

namespace MyApp\System\Exceptions;

use Exception;

class Message extends Exception
{
    public function __construct($mensagem, $codigo = 0, Exception $anterior = null)
    {
        parent::__construct($mensagem, $codigo, $anterior);
    }
}
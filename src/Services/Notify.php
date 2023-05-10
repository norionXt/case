<?php

namespace MyApp\Services;

use Exception;
use MyApp\System\Interfaces\IFetch;

class Notify {

    private IFetch $fetch;
    const URL = 'http://o4d9z.mocklab.io/notify';

    function __construct(IFetch $fetch)
    {
        $this->fetch =  $fetch;
    }

    function send(array $data){
        $result  = $this->fetch->get(Moncky::URL);
        if  ($result->message !== "Success") {
            return throw new Exception("Serviço de notificação está indisponível no momento");
        }
    }
}
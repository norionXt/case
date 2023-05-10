<?php

namespace MyApp\Services;
use MyApp\System\Interfaces\IFetch;

class Moncky {

    private IFetch $fetch;
    const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    function __construct(IFetch $fetch)
    {
        $this->fetch =  $fetch;
    }

    function isAuthorized(){
        $result  = $this->fetch->get(Moncky::URL);
        return $result->message === "Autorizado";
    }
}
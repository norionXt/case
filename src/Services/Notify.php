<?php

namespace MyApp\Services;
use MyApp\System\Interfaces\IFetch;

class Notify {

    private IFetch $fetch;
    const URL = 'http://o4d9z.mocklab.io/notify';

    function __construct(IFetch $fetch)
    {
        $this->fetch =  $fetch;
    }

    function send(array $data){
        $result  = $this->fetch->post(Moncky::URL, $data, [ 'header' => 'Content-Type: application/x-www-form-urlencoded',]);
        return $result->message === "Autorizado";
    }
}
<?php

namespace MyApp\Services;

use Exception;
use MyApp\Model\Jobs;
use MyApp\System\Interfaces\IFetch;

class Notify {

    private IFetch $fetch;
    const URL = 'http://o4d9z.mocklab.io/notify';

    function __construct(IFetch $fetch)
    {
        $this->fetch =  $fetch;
    }

    function send(array $data){
        try {
            $result  = $this->fetch->get(Moncky::URL);
            return $result->message === "Success";
        } catch(Exception $e) {
            (new Jobs())->insert(['class' => serialize($this), 'method' =>'send', 'params' => implode('|', $data)]);
        }

    }
}
<?php


namespace MyApp\Modules\Register;

use MyApp\System\Interfaces\IResponse;

class RegisterUser {

    private IResponse $response;

    function __construct(IResponse $response)
    {
        $this->response = $response;
    }

    function register():IResponse {

    }


}
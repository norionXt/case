<?php

namespace MyApp\Controller;

use MyApp\Modal\Usuarios as ModalUsuarios;
use MyApp\Model\Usuarios;
use MyApp\Modules\Payment\Transfer;
use MyApp\Modules\User\Register;
use MyApp\System\Interfaces\IRequest;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Config\Config;

class users
{

    public static function store(IRequest $request, IResponse $response)
    {

        $register = new Register(
            $response,
            new Usuarios()
        );

        return $register->register([
            'nomeCompleto'  => $request->input('nomeCompleto'),
            'email' => $request->input('email'),
            'cpf'   => $request->input('cpf'),
            'cnpj'  => $request->input('cnpj'),
            'senha' => $request->input('senha'),
        ]);
    }


    public static function transfer(IRequest $request, IResponse $response)
    {
        $transfer = new Transfer($response, new Usuarios());

        $transfer->execute([
            'payer' => $request->input('payer'),
            'payee' => $request->input('payee'),
            'value' => $request->input('value'),
        ]);
    }

}

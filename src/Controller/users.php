<?php

namespace MyApp\Controller;

use Exception;
use MyApp\Model\Users as ModelUsers;
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
            new ModelUsers()
        );

        $result = $register->register([
            'nomeCompleto'  => $request->input('nomeCompleto'),
            'email' => $request->input('email'),
            'cpf'   => $request->input('cpf'),
            'cnpj'  => $request->input('cnpj'),
            'senha' => $request->input('senha'),
        ]);

        $status = intval($result['status']);
        $response->status($status)->sendJson($result);
    }


    public static function transfer(IRequest $request, IResponse $response)
    {
        $transfer = new Transfer($response, new ModelUsers());

        $result = $transfer->execute([
            'payer' => $request->input('payer'),
            'payee' => $request->input('payee'),
            'value' => $request->input('value'),
        ]);
        $status = intval($result['status']);
        $response->status($status)->sendJson($result);

    }

}

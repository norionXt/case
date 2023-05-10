<?php

namespace MyApp\Controller;

use Exception;
use MyApp\Model\Usuarios;
use MyApp\Modules\Payment\Transfer;
use MyApp\Modules\User\Register;
use MyApp\System\Interfaces\IRequest;
use MyApp\System\Interfaces\IResponse;

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
        try {
            $transfer->execute([
                'payer' => $request->input('payer'),
                'payee' => $request->input('payee'),
                'value' => $request->input('value'),
            ]);
            $response->status(200)->sendJson(
                [
                    'message' => 'Transferência realizada com sucesso'
                ]
            );
        } catch(Exception $e) {
            $response->status(400)->sendJson(['message' => $e->getMessage()]);
        }

    }

}

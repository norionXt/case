<?php

namespace MyApp\Controller;

use MyApp\Modal\Usuarios as ModalUsuarios;
use MyApp\System\Interfaces\IRequest;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Config\Config;

class usuarios
{

    public static function store(IRequest $request, IResponse $response)
    {

        $name  = $request->input('nomeCompleto');
        $email = $request->input('email');
        $cpf   = $request->input('cpf');
        $cnpj  = $request->input('cnpj');
        $password = $request->input('senha');
        $config = new Config();        


        if(in_array(false,[$name, $email, $cpf,  $password])) {

            return $response
            ->status(404)
            ->sendJson([
                'status' => $config->get('WARNING'),
                'message' => 'Falta informação, revise os dados novamente'
            ]);
        }

        $user = new ModalUsuarios();

        $userExist = $user->where('email','=',$email)->select(['*']);

        if($userExist !== false) {
            return $response
            ->status(404)
            ->sendJson([
                'status' => $config->get('WARNING'),
                'message' => 'Usuário já cadastrado'
            ]);
        }

        $user->insert([
            'nomeCompleto' => $name,
            'email' => $email,
            'cpf' => $cpf,
            'cnpj' => $cnpj,
            'senha' => $password
        ]);

        return $response
        ->status(200)
        ->sendJson(["status"=> $config->get('SUCCESS'), 'message' => 'Usuário cadastrado com sucesso']);
    }


    public static function update(IRequest $request, IResponse $response)
    {
        return $response->header('Content-Type json/html')->send("update");
    }

}

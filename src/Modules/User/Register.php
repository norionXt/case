<?php


namespace MyApp\Modules\User;

use Exception;
use MyApp\System\Interfaces\IModel;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Config\Config;

class Register {

    private IResponse $response;
    private IModel    $user;    

    function __construct(IResponse $response,IModel $user)
    {
        $this->response = $response;
        $this->user     = $user;        
    }

    function register(array $columnsValue) {

        $name  = $columnsValue['nomeCompleto'];
        $email = $columnsValue['email'];
        $cpf   = $columnsValue['cpf'];
        $cnpj  = $columnsValue['cnpj'];
        $password = $columnsValue['senha'];

        try {

            $this->dadosInvalid([$name, $email, $cpf, $password]);
            $this->userExists($email, $cpf);
           

            $this->user->insert([
                'nomeCompleto' => $name,
                'email' => $email,
                'cpf' => $cpf,
                'cnpj' => $cnpj,
                'senha' => $password
            ]);

            return $this->responseOk();
        } catch(Exception $e) {
          
            return [ 'status' => (new Config())->get('ERROR'),
                    'message' => $e->getMessage()
                ];
        }
    }


    private function dadosInvalid(array $dados){
        if (in_array(false, $dados) ) {
            return throw new Exception("Existe dados inválidos");
        }
    }


    private function userExists($email, $cpf) {
        $userExist = $this->user
            ->where("email", "=", $email, "or")
            ->where("cpf", "=", $cpf)
            ->select(['*']);


        if ($userExist !== false) {
            return throw new Exception('Usuário já cadastrado');
        }
    }

    private function responseOk() {
        return [ 
            'status' => (new Config())->get('SUCCESS'),
            'message' => 'Usuário cadastrado com sucesso'];
    }
}
<?php
namespace MyApp\Modules\Payment;

use Exception;
use MyApp\Modules\Payment\Traits\ValidateDatas;
use MyApp\System\Interfaces\IUsers;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Config\Config;

class Transfer {
use ValidateDatas;

    private IResponse $response;
    private IUsers    $user;    

    function __construct(IResponse $response, IUsers $user)
    {
        $this->response = $response;
        $this->user     = $user;        
    }

    function execute(array $record) {

        try {

            $this->validateRequestValues($record);

            $this->lackOfData($record);

            $payer = $this->user->getUserId($record['payer']);
            $payee = $this->user->getUserId($record['payee']);

            if(!$payer or !$payee) {
                throw new Exception('Usuários não existem');
            }

            if( $this->user->isStore($payer) ) {
                throw new Exception('Lojistas não podem fazer pagamentos');
            }

            $this->enoughMoney($payer['saldo'], $record['value']);

            if($this->transferAuthorized()) {
                $result  = $this->executeTransfer($record);

                $notifyOK =  $this->ifTransferSuccessNotify($result, $payee['id']);
                $config   = new Config(); 
                if($notifyOK) {

                    return ["message"=>"Transferência feita com sucesso mas notificação está indisponível.",
                        "status"=>$config->get('SUCCESS')];
                } else {
                    return ["message"=>"Transferência feita com sucesso mas notificação está indisponível.",
                    "status" => $config->get('SUCCESS_ERRO_THIRD')];
                }

            } else {
                throw new Exception('Tranferência não autorizada');
            }
        }catch(Exception $e) {
            return throw new Exception($e->getMessage());
        }        

    }

 

}

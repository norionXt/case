<?php
namespace MyApp\Modules\Payment;

use Exception;
use MyApp\Model\Payment;
use MyApp\Services\Moncky;
use MyApp\Services\Notify;
use MyApp\System\Interfaces\IUsuarios;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Fetch\Fetch;

class Transfer {

    private IResponse $response;
    private IUsuarios    $user;    

    function __construct(IResponse $response, IUsuarios $user)
    {
        $this->response = $response;
        $this->user     = $user;        
    }

    function execute(array $record) {

        try {
            $this->lackOfData($record);

            $payer = $this->user->getUserId($record['payer']);
            $payee = $this->user->getUserId($record['payee']);

            if(!$payer or !$payee) {
                throw new Exception('Usuários não existem');
            }

            if( $this->user->isStore($payer) ) {
                throw new Exception('Lojista não pode fazer pagamentos');
            }

            $this->notCanTransfer($payer['saldo'], $record['value']);

            $this->valueInvalid($record['value']);

            if($this->transferAuthorized()) {
                $result  = $this->executeTransfer($record);

                (new Notify(
                    new Fetch()
                ))->send(['id' => $payee['id']]);

                return $this->response->status(200)->sendJson(
                    [
                        'message' => $result['Resultado']
                    ]
                );

            } else {
                throw new Exception('Tranferência não autorizada');
            }
        }catch(Exception $e) {
            $this->response->status(400)->sendJson(['message' => $e->getMessage()]);
        }

        

    }

    private function lackOfData($record) {
        if( !$record['value'] or !$record['payer'] or !$record['payee']) {
            return throw new Exception( 'Revise os dados da requisição');
        }
    }

    private function transferAuthorized() {
        $service = new Moncky(
            new Fetch()
        );

        return $service->isAuthorized();
    }

    private function notCanTransfer($saldo, $value) {
        if(  intval($saldo) < intval($value) ) {
            return throw new Exception('Saldo insuficiente');
        }
    }

    private function executeTransfer(array $record) {
        $result  = (new Payment())
        ->transfer($record['payer'], $record['payee'], $record['value']);
        return $result;
    }


    private function valueInvalid($value) {
         if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
            return throw new Exception("Valor para transferência é inválido");
        }
    }

}
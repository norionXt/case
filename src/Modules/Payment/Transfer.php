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

            $this->validateRequestValues($record);

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



            if($this->transferAuthorized()) {
                $result  = $this->executeTransfer($record);

                if($result['Resultado'] === 'Transação efetivada com sucesso.') {
                    (new Notify(
                        new Fetch()
                    ))->send(['id' => $payee['id']]);
                }
                

            } else {
                throw new Exception('Tranferência não autorizada');
            }
        }catch(Exception $e) {
            return throw new Exception($e->getMessage());
        }

        

    }

    private function lackOfData($record) {
        if( !$record['value'] or !$record['payer'] or !$record['payee']) {
            return throw new Exception( 'Revise os dados da requisição');
        }
    }

    private function validateRequestValues(array $record) {
        try {
            $moneyRegex = '/^\d+(\.\d{1,2})?$/';
            $this->valueInvalid($record['value'], $moneyRegex, 'Valor de transferência é inválido');

            $onlyNumber = '/^[0-9]+$/';
            $this->valueInvalid($record['payer'], $onlyNumber, 'id está errada');
            $this->valueInvalid($record['payee'], $onlyNumber, 'id está errada');
        } catch(Exception $e) {
            return throw new Exception($e->getMessage());
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


    private function valueInvalid($value, $regex, $message) {
         if (!preg_match($regex, $value)) {
            return throw new Exception($message);
        }
    }

}
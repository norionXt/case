<?php
namespace MyApp\Modules\Payment;

use Exception;
use MyApp\Model\Payment;
use MyApp\Modules\Payment\Traits\ValidateDatas;
use MyApp\Services\Moncky;
use MyApp\Services\Notify;
use MyApp\System\Interfaces\IUsuarios;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Fetch\Fetch;

class Transfer {
use ValidateDatas;

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
                throw new Exception('Lojistas não podem fazer pagamentos');
            }

            $this->enoughMoney($payer['saldo'], $record['value']);

            if($this->transferAuthorized()) {
                $result  = $this->executeTransfer($record);

                return $this->ifTransferSuccessNotify($result, $payee['id']);

            } else {
                throw new Exception('Tranferência não autorizada');
            }
        }catch(Exception $e) {
            return throw new Exception($e->getMessage());
        }        

    }

 

}

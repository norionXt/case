<?php

namespace MyApp\Modules\Payment\Traits;

use Exception;
use MyApp\Model\Payment;
use MyApp\Services\Moncky;
use MyApp\Services\Notify;
use MyApp\System\Interfaces\IResponse;
use MyApp\System\Modules\Fetch\Fetch;

trait ValidateDatas {
    private function lackOfData($record)
    {
        if (!$record['value'] or !$record['payer'] or !$record['payee']) {
            return throw new Exception('Revise os dados da requisição');
        }
    }

    private function validateRequestValues(array $record)
    {
        try {
            $moneyRegex = '/^\d+(\.\d{1,2})?$/';
            $this->valueInvalid($record['value'], $moneyRegex, 'Valor de transferência é inválido');

            $onlyNumber = '/^[0-9]+$/';
            $this->valueInvalid($record['payer'], $onlyNumber, 'id está errada');
            $this->valueInvalid($record['payee'], $onlyNumber, 'id está errada');
        } catch (Exception $e) {
            return throw new Exception($e->getMessage());
        }
    }

    private function transferAuthorized()
    {
        $service = new Moncky(
            new Fetch()
        );

        return $service->isAuthorized();
    }

    private function enoughMoney($saldo, $value)
    {
        if (intval($saldo) < intval($value)) {
            return throw new Exception('Saldo insuficiente');
        }
    }

    private function executeTransfer(array $record)
    {
        $result  = (new Payment())
            ->transfer($record['payer'], $record['payee'], $record['value']);
         
        if($result['Resultado'] == 'Erro na transação') {
            return throw new Exception($result['Resultado']);
        }
    }


    private function valueInvalid($value, $regex, $message)
    {
        if (!preg_match($regex, $value)) {
            return throw new Exception($message);
        }
    }


    private function ifTransferSuccessNotify( $idPayee) {
        return (new Notify(
                new Fetch()
            ))->send(['id' => $idPayee ]);
    }

}

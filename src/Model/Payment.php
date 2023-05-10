<?php


namespace MyApp\Model;

use MyApp\System\Interfaces\IPayment;
use MyApp\System\Modules\Model\Model;

class Payment extends Model implements IPayment {

   

    public function transfer($idPayer, $idPayee, $value) {
        

       return $this->query('call pay( :idPayer, :idPayee, :saldo)', [
            'idPayer' => $idPayer,
            'idPayee' => $idPayee,
            'saldo'   => $value,                        
        ]);
    }


}
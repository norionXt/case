<?php


namespace MyApp\System\Interfaces;


interface IPayment {
    public function transfer($idPayer, $idPayee, $value);
}
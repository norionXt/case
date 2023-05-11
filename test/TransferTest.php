<?php

use MyApp\Model\Users as ModelUsers;
use MyApp\Modules\Payment\Transfer;
use MyApp\System\Modules\Route\Response;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase{

   


    public function testTransferError()
    {

        try {
            $result = (new Transfer(new Response(), new ModelUsers()))
                ->execute([
                    "payee" => "4",
                    "payer" => "10a",
                    "value" => "20.01"
                ]);

            $this->assertTrue($result);
        } catch (Exception $e) {
            $this->assertFalse(false);
        }
    }

}
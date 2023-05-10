<?php


namespace MyApp\Model;

use MyApp\System\Interfaces\IUsuarios;
use MyApp\System\Modules\Model\Model;

class Usuarios extends Model implements IUsuarios {


    public function isStore(array $user) {
        return !empty($user['cnpj']);
    }

    public function getUserId($id) {
        $user = $this->where('id','=',$id)->select(['*']);
        return $user ? $user: false; 
    }

}
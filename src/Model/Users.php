<?php


namespace MyApp\Model;

use MyApp\System\Interfaces\IUsers;
use MyApp\System\Modules\Model\Model;

class Users extends Model implements IUsers {


    public function isStore(array $user) {
        return !empty($user['cnpj']);
    }

    public function getUserId($id) {
        $user = $this->where('id','=',$id)->select(['*']);
        return $user ? $user: false; 
    }

}
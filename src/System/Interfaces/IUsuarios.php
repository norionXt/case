<?php


namespace MyApp\System\Interfaces;


interface IUsuarios {
    public function isStore(array $user);
    public function getUserId($id);
}
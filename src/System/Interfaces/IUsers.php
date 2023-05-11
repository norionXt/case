<?php


namespace MyApp\System\Interfaces;


interface IUsers {
    public function isStore(array $user);
    public function getUserId($id);
}
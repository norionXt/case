<?php
namespace MyApp\System\Traits;


trait Menssage {
    function addTextInGreen(string $text) {
        $text = str_replace('!{',"\033[32m", $text);
        $text = str_replace('}!',"\033[0m", $text);
        return $text;
    }

}
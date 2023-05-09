<?php

namespace MyApp\System\Commands;

use MyApp\System\Traits\GetClassDir;
use MyApp\System\Traits\Menssage;

class Help {
    use Menssage, GetClassDir;

    function __toString() {
        $message = "";

        foreach ($this->getClass(__DIR__) as $class) {
            $class = "MyApp\System\Commands\\".$class;
            if(in_array('MyApp\System\Interfaces\ICommands', class_implements(new $class()))) {
                $message.= "\n".(new $class())->help()."\n";
            }

        }

        $message = $this->addTextInGreen($message);

        return $message;
    }

}


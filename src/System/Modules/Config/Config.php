<?php


namespace MyApp\System\Modules\Config;

use MyApp\System\Interfaces\IConfig;

class Config implements IConfig{

    function __construct()
    {
        if($this->get('HOST')) {
            return;
        }
        $this->loadConfig(dirname(__FILE__,5).'\.env');
    }

    private function loadConfig(string $pathFile) {
        $handle = fopen($pathFile,'r');
        
        if( $handle ) {
            while (($line = fgets($handle)) !== false) {
                $line = str_replace("\n",'',$line);
                $this->put($line);
            }

            fclose($handle);
        }
    }

    function get(string $config) {
        return trim(getenv($config));
    }

    function put(string $config) {
        putenv($config);
    }
}
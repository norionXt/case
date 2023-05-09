<?php
namespace MyApp\System\Traits;



trait GetClassDir {
    function getClass($dir, ): array {
        $files = scandir($dir);

        $listClass = array_filter( $files, function ($file) {
            return strpos($file,'.php');
        });

        $listClass = array_map(function ($file) {
            $pathWithoutExt = str_replace('.php','',$file);
            return $pathWithoutExt;
        }, $listClass);


        return $listClass;
    }

}
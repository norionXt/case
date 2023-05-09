<?php
namespace MyApp\System\Traits;


trait Template {
    private function createTemplate(string $nameClass, string $template, string $dir) {
        $templateContent = file_get_contents(dirname(__DIR__,1)."/Commands/Template/{$template}");
        $contentClassController = str_replace('NameClass', $nameClass, $templateContent );


        $dir = dirname(__DIR__,2)."/{$dir}";
        $filename = "/{$nameClass}.php";
        $path = $dir . $filename;
        $file = fopen($path, 'w');

        // escreve dados no arquivo
        fwrite($file, $contentClassController);

        // fecha o arquivo
        fclose($file);
    }

}
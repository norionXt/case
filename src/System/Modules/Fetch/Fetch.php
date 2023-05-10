<?php

namespace MyApp\System\Modules\Fetch;

use Exception;
use MyApp\System\Interfaces\IFetch;

class Fetch implements IFetch{

    function get(string $url) {

        // Inicia o cURL
        $curl = curl_init();

        // Configura as opções do cURL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Executa a requisição
        $response = curl_exec($curl);

        // Verifica se houve algum erro durante a requisição
        if (curl_errno($curl)) {
           return throw new Exception('Erro ao buscar serviço remoto: ' . curl_error($curl));
        }

        // Fecha o cURL
        curl_close($curl);
  
        return json_decode($response);
    }


    function post($url, $data) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_error($ch)) {
            return throw new Exception('Erro ao acessar serviço remoto: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response);
    }

}
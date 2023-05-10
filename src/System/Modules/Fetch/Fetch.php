<?php

namespace MyApp\System\Modules\Fetch;

use MyApp\System\Interfaces\IFetch;

class Fetch implements IFetch{

    function get(string $url) {
        $response = file_get_contents($url);
        return json_decode($response);
    }


    function post( string $url, array $data = [], array $header = []) {
        $options = array(
            'http' => array(
                'method' => 'POST',
                ...$header,
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result);
    }
}
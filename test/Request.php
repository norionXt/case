<?php

use MyApp\System\Modules\Route\Request;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use MyApp\System\Interfaces\IConfig;
use MyApp\System\Modules\Config\Config;

final class RequestTest extends TestCase{

    protected $client;

    private IConfig $config;
    private string $domainUrl;
    

    function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name,$data,$dataName);
        $this->config = new Config();
        $this->domainUrl = $this->config->get('domain');
    }

    public function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://'.$this->domainUrl,
        ]);
    }

    
    public function Example()
    {
        $response = $this->client->request('GET', '/path/to/endpoint');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }


}
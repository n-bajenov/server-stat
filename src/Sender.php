<?php


namespace Bajenov\ServerStatAgent;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Sender
{
    private $url;
    private $method;

    public function __construct(string $sendToUrl, string $method)
    {
        if (!filter_var($sendToUrl, FILTER_VALIDATE_URL)) {
            throw new \Exception('Url is not valid');
        }

        $this->url = $sendToUrl;
        $this->method = $method;
    }

    public function send(array $data, array $headers = [])
    {

        $client = new Client(['base_uri' => $this->url]);
        $response = $client->request('POST', $this->method, [
            'headers' => $headers,
            'json' => $data
        ]);

    }
}
<?php


namespace Bajenov\ServerStatAgent;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Sender
{
    private $url;
    private $method;

    public function __construct(string $sendToUrl)
    {
        if (!filter_var($sendToUrl, FILTER_VALIDATE_URL)) {
            throw new \Exception('Url is not valid');
        }

        $this->url = parse_url($sendToUrl, PHP_URL_HOST);
        $this->method = parse_url($sendToUrl, PHP_URL_PATH) . '?' . parse_url($sendToUrl, PHP_URL_QUERY);
    }

    public function send(array $data, array $headers = [])
    {

        $client = new Client(['base_uri' => $this->url, 'verify' => false]);
        $response = $client->request('POST', $this->method, [
            'headers' => $headers,
            'json' => $data
        ]);

    }
}

<?php


namespace Bajenov\ServerStatAgent;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Sender
{
    private $url;
    

    public function __construct(string $sendToUrl)
    {
        if (!filter_var($sendToUrl, FILTER_VALIDATE_URL)) {
            throw new \Exception('Url is not valid');
        }

        $this->url = $sendToUrl;
        
    }

    public function send(array $data, array $headers = [])
    {
	
        $client = new Client();
        $response = $client->request('POST', $this->url, [
            'headers' => $headers,
            'json' => $data
        ]);

    }
}

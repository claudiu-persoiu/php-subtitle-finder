<?php

namespace Provider\OpenSubtitles;

use Core\Config;

class ConnectionManager
{
    const ENDPOINT_URL = 'https://api.opensubtitles.org/xml-rpc';

    protected $config;

    protected $token;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function call($method, $data)
    {
        return $this->makeCall(
            $method,
            [
                $this->getToken(),
                [
                    array_merge(['sublanguageid' => $this->config->getLanguage()], $data)
                ]
            ]
        );
    }

    public function getToken()
    {
        if (!$this->token) {
            $result = $this->makeCall(
                'LogIn',
                [
                    $this->config->getUsername(),
                    $this->config->getPassword(),
                    $this->config->getLanguage(),
                    $this->config->getUseragent()
                ]
            );

            $this->token = $result['token'];
        }

        return $this->token;
    }

    protected function makeCall($method, $data)
    {
        $context  = stream_context_create(
            array(
                'http' => array(
                    'method'  => "POST",
                    'header'  => "Content-Type: text/xml",
                    'content' => xmlrpc_encode_request(
                        $method,
                        $data
                    )
                )
            )
        );
        $response = file_get_contents(self::ENDPOINT_URL, false, $context);

        if (!$response) {
            throw new \Exception('Unable to make request');
        }

        return $this->checkResponseForErrors($response);
    }

    protected function checkResponseForErrors($rawResponse)
    {
        $response = xmlrpc_decode($rawResponse);

        if (!$response) {
            throw new \Exception('Invalid XMLRPC result');
        }

        if (xmlrpc_is_fault($response)) {
            throw new \Exception(sprintf('XMLRPC Fault: %s (%s)', $response['faultString'], $response['faultCode']));
        }

        return $response;
    }
}
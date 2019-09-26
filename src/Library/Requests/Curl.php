<?php
namespace PB\Library\Requests;


class Curl implements RequestInterface
{
    /**
     * @var array
     */
    private $body;

    /**
     * @var array
     */
    private $header;

    /**
     * @var array
     */
    private $config = [
        CURLOPT_TIMEOUT => 60,
        CURLOPT_RETURNTRANSFER =>  true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_POST => false,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => '',
    ];

    /**
     * Curl constructor.
     */
    public function __construct()
    {
        if (!extension_loaded('curl')) {
            throw new \RuntimeException('The cURL extensions is not loaded, make sure you have installed the cURL extension');
        }
    }

    /**
     * @param string $url
     */
    public function get(string $url)
    {
       $this->request($url);
    }

    /**
     * @param array|null $options
     */
    public function body(?array $options = null)
    {
        $this->body = $options ?? $this->config;
    }

    /**
     * @param array|null $options
     */
    public function head(array $options = null)
    {
        $this->header = $options;
    }

    protected function request(string $url)
    {
        $curl = curl_init($url);

        curl_setopt_array($curl, $this->body);

        $response = curl_exec($curl);

    }
}
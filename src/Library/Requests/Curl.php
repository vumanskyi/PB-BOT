<?php
declare(strict_types=1);

namespace PB\Library\Requests;

use PB\Library\Responses\ResponseInterface;

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
     * @var ResponseInterface
     */
    protected $response;

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
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        if (!extension_loaded('curl')) {
            throw new \RuntimeException('The cURL extensions is not loaded, make sure you have installed the cURL extension');
        }

        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function get(string $url, array $options = []): ResponseInterface
    {
       $result = $this->request($url . '?' . $this->params($options));

       $this->getResponse()->setParams($result);

       return $this->getResponse();
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

    /**
     * Send data to bot
     *
     * @param string $url
     * @return bool|string
     */
    protected function request(string $url)
    {
        $curl = curl_init($url);

        curl_setopt_array($curl, $this->body ?? $this->config);

        $response = curl_exec($curl);

        $error    = curl_error($curl);
        $errno    = curl_errno($curl);

        curl_close($curl);

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }


        return $response;
    }

    /**
     * @param array $params
     * @return string
     */
    protected function params(array $params)
    {
        return http_build_query($params);
    }
}
<?php
declare(strict_types=1);

namespace PB\Library\Requests;

use PB\Library\Responses\ResponseInterface;

interface RequestInterface
{
    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function get(string $url, array $options = []): ResponseInterface;

    /**
     * @param array $options
     */
    public function head(array $options);

    /**
     * @param array $options
     */
    public function body(array $options);
}
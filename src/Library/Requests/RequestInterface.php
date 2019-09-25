<?php
namespace PB\Library\Requests;


interface RequestInterface
{
    /**
     * @param string $url
     */
    public function get(string $url);

    /**
     * @param array $options
     */
    public function head(array $options);

    /**
     * @param array $options
     */
    public function body(array $options);
}
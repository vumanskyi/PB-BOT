<?php
namespace PB\Config;

use ArrayAccess;
use PB\Exception\FileNotFoundException;

interface ConfigInterface extends ArrayAccess
{
    /**
     * Set resource
     */
    public function resource();

    /**
     * @param string $path
     * @throws FileNotFoundException
     */
    public function source(string $path);

}
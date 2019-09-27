<?php
declare(strict_types=1);

namespace PB\Config;

use ArrayAccess;
use PB\Exception\FileNotFoundException;

interface ConfigInterface extends ArrayAccess
{
    /**
     * @return string
     */
    public function source(): string;

    /**
     * @return array
     */
    public function data(): array;

}
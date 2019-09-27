<?php
declare(strict_types=1);

namespace PB\Library\Responses;

interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function getParams();

    /**
     * @param mixed $params
     */
    public function setParams($params): void;

    /**
     * @return string
     */
    public function render(): string;
}
<?php
declare(strict_types=1);

namespace PB\Library\Responses;

class ResponseJson implements ResponseInterface
{
    /**
     * @var mixed
     */
    private $params;

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $params = $this->getParams();

        if (!is_string($params)) {
            throw new \RuntimeException('Something is going wrong!');
        }

        return $this->isJson($params) ? $params : json_encode($params);
    }

    /**
     * @param string $json
     * @return bool
     */
    public function isJson(string $json): bool
    {
        json_decode($json);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
<?php
namespace PB\Validation;

use OutOfBoundsException;
use PB\Config\ConfigInterface;

class WebValidation extends Validation
{
    /**
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config): void
    {
        parent::setConfig($config);
        $this->operate();
    }

    /**
     * Depend on environment. Every environment has own configuration
     */
    public function operate()
    {
        $data = $this->getConfig()->data();

        if (empty($data['request']) || empty($data['request']['web'])) {
            throw new OutOfBoundsException('The filed "web" doesn\'t found');
        }

        $this->fields = array_keys($data['request']['web']);
        $this->rules = $data['request']['web'];
    }

    /**
     * @return string
     */
    public function availableMethods(): string
    {
        //get and post
        return '';
    }


    /**
     * @param string $method
     * @return bool
     */
    public function isMethodAvailabel(string $method): bool
    {
        return in_array($method, $this->availableMethods());
    }
}
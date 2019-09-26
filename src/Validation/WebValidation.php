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

        if (empty($data['web'])) {
            throw new OutOfBoundsException('The filed "web" doesn\'t found');
        }

        $this->fields = array_keys($data['web']);
        $this->rules = $data['web'];
    }
}
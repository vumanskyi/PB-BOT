<?php
namespace PB\Validation;

use OutOfBoundsException;
use PB\Config\ConfigInterface;

class SapiValidation extends Validation
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

        if (empty($data['request']) || empty($data['request']['sapi'])) {
            throw new OutOfBoundsException('The filed "sapi" doesn\'t found');
        }

        $this->fields = array_keys($data['request']['sapi']);
        $this->rules = $data['request']['sapi'];
    }

}
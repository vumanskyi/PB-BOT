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

        if (empty($data['sapi'])) {
            throw new OutOfBoundsException('The filed "sapi" doesn\'t found');
        }

        $this->fields = array_keys($data['sapi']);
        $this->rules = $data['sapi'];
    }

    /**
     * @param array $request
     * @return bool
     */
    public function validate(array $request): bool
    {
        // TODO: Implement validate() method.
    }
}
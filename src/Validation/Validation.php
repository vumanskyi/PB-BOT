<?php
namespace PB\Validation;

use PB\Config\ConfigInterface;

abstract class Validation
{
    const ENV_SAPI = 'cli';
    const ENV_WEB = 'web';

    const L_REQUIRED = 'required';

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var array
     */
    protected $validMessage;

    /**
     * Get rules for environment
     * @return array
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * Check only for some values
     * @return array
     */
    public function fields(): array
    {
        return $this->fields;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * Check what environment it is and return back value
     * @return string
     */
    public function getEnvironment(): string
    {
        return self::isSAPI() ? self::ENV_SAPI : self::ENV_WEB;
    }

    /**
     * @return array
     */
    public static function isSAPI(): bool
    {
        return PHP_SAPI === self::ENV_SAPI;
    }

    /**
     * @param ConfigInterface $config
     * @return void
     */
    public function setConfig(ConfigInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * @param array $request
     * @return bool
     */
    public function validate(array $request): bool
    {
        $msg = [];
        $isValid = true;
        foreach ($this->rules as $key => $value) {
            if ($value == static::L_REQUIRED) {
                if (array_key_exists($key, $request) && empty($request[$key])) {
                    $isValid = false;
                    $msg[$key] = 'The field is required';
                    break;
                } elseif (!array_key_exists($key, $request)) {
                    $isValid = false;
                    $msg[$key] = 'The field is required';
                    break;
                }
            }
        }

        $this->validMessage = $msg;

        return $isValid;
    }

    /**
     * @return array
     */
    public function getValidMessage(): array
    {
        return $this->validMessage;
    }

    /**
     * Depend on environment. Every environment has own configuration
     */
    abstract public function operate();

}
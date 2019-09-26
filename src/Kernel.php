<?php
namespace PB;

use PB\Config\ConfigInterface;
use PB\Contracts\Application;
use PB\Contracts\Kernel as BaseKernel;
use PB\Validation\SapiValidation;
use PB\Validation\Validation;
use PB\Validation\WebValidation;

class Kernel implements BaseKernel
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @var Validation
     */
    private $validation;


    /**
     * Kernel constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     * Get service provider
     *
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->app;
    }

    /**
     * @return Validation
     */
    public function getValidation(): Validation
    {
        return $this->validation;
    }

    /**
     * @param Validation $validation
     */
    public function setValidation(Validation $validation): void
    {
        $this->validation = $validation;
    }

    /**
     * Entry point of application
     * Script run here
     */
    public function execution()
    {
        if (Validation::isSAPI()) {
            //logic for sapi
            $validation = new SapiValidation();
        } else {
            $validation = new WebValidation();
        }

        $validation->setConfig(
            $this->getApplication()->getBind(ConfigInterface::class)
        );

        $this->getApplication()->get('Logger')->info('test message');
    }

    /**
     * Which environment do you use in you application ?
     * There ara only the next options: test, dev, prod
     */
    public function getDevEnvironment()
    {
       return getenv('APP_ENV');
    }
}
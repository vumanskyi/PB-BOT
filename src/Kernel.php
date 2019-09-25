<?php
namespace PB;

use PB\Contracts\Application;
use PB\Contracts\Kernel as BaseKernel;

class Kernel implements BaseKernel
{

    /**
     * @var Application
     */
    private $app;

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
     * Entry point of application
     * Script run here
     */
    public function execution()
    {
        if ($this->isSAPI()) {
            // cli
        } else {
            // web
        }
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

    /**
     * This mean that where is application running ?
     * SLI or from web browser
     */
    public function getEnvironment()
    {
        return $this->isSAPI() ? 'cli' : 'web';
    }

    /**
     * Check if this is cli env
     * @return array
     */
    public function isSAPI(): bool
    {
        return PHP_SAPI === 'cli';
    }
}
<?php
namespace PB\Contracts;


interface Kernel
{
    /**
     * Get service provider
     *
     * @return Application
     */
    public function getApplication(): Application;

    /**
     * Entry point of application
     * Script run here
     */
    public function execution();

    /**
     * Which environment do you use in you application ?
     * There ara only the next options: test, dev, prod
     */
    public function getDevEnvironment();
}
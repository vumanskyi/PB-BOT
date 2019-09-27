<?php
declare(strict_types=1);

namespace PB\Contracts;


interface Application
{
    const VERSION = '0.1.0';

    /**
     * Get current version of application
     *
     * @return string
     */
    public function version(): string;

    /**
     * Get base path to application
     *
     * @return string
     */
    public function basePath(): string;

    /**
     * Register a service provider with the application
     *
     * @param string $class
     * @param $service
     * @return void
     */
    public function addInstance(string $class, $service): void;

    /**
     * Register a class with the application
     *
     * @param string $class
     * @param array $params
     * @return void
     */
    public function addClass(string $class, array $params = []): void;

    /**
     * Check if application has current interface or class
     *
     * @param string $interface
     * @return bool
     */
    public function has(string $interface): bool;

    /**
     * Get class by class name
     * @param string $class
     */
    public function get(string $class);

    /**
     * @param string $interface
     * @param object $class
     * @return void
     */
    public function bind(string $interface, object $class);

    /**
     * @param string $interface
     * @return bool|mixed
     */
    public function getBind(string $interface);
}
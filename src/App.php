<?php
declare(strict_types=1);

namespace PB;

use PB\Contracts\Application;

class App implements Application
{
    /**
     * @var string[][]
     */
    private $services = [];

    /**
     * @var array
     */
    private $instanced = [];

    /**
     * @var array
     */
    private $bind = [];

    /**
     * @return string
     */
    public function version(): string
    {
        return static::VERSION;
    }

    /**
     * @param string $interface
     * @param object $class
     */
    public function bind(string $interface, object $class)
    {
        $this->bind[$interface] = $class;
    }

    /**
     * @param string $class
     * @param $service
     */
    public function addInstance(string $class, $service): void
    {
        $this->instanced[$class] = $service;
    }

    /**
     * @param string $class
     * @param array $params
     */
    public function addClass(string $class, array $params = []): void
    {
        $this->services[$class] = $params;
    }

    /**
     * @param string $interface
     * @return bool
     */
    public function has(string $interface): bool
    {
        return isset($this->services[$interface]) || isset($this->instanced[$interface]);
    }

    /**
     * @param string $interface
     * @return bool|mixed
     */
    public function getBind(string $interface)
    {
        if (isset($this->bind[$interface])) {
            return $this->bind[$interface];
        }

        return false;
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function get(string $class): object
    {
        if (isset($this->instanced[$class])) {
            return $this->instanced[$class];
        }

        $args = $this->services[$class];

        switch (count($args)) {
            case 0:
                $object = new $class();
                break;
            case 1:
                $object = new $class($args[0]);
                break;
            case 2:
                $object = new $class($args[0], $args[1]);
                break;
            case 3:
                $object = new $class($args[0], $args[1], $args[2]);
                break;
            default:
                throw new \OutOfRangeException('Too many arguments given');
        }

        $this->services[$class] = $object;

        return $object;
    }

    /**
     * Get base path to application
     *
     * @return string
     */
    public function basePath(): string
    {
        return PATH;
    }
}
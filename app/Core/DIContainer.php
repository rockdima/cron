<?php

namespace App\Core;

/**
 * Dependency Injection Container
 */

class DIContainer {
    private array $instances = [];

    /**
     * Add Instance 
     * 
     * @param string $class class name
     * @param object $instance instance of a class
     */
    public function set(string $class, object $instance): void {
        $this->instances[$class] = $instance;
    }

    /**
     * Get Instance
     * 
     * @param string $class class name
     */
    public function get(string $class): object {
        // if not exist create one
        if (!isset($this->instances[$class])) {
            $this->instances[$class] = $this->resolve($class);
        }
        return $this->instances[$class];
    }

    /**
     * Create/Resolve Instance
     * 
     * @param string $class class name to resolve
     * @return object
     */
    private function resolve(string $class): object {
        $reflector = new \ReflectionClass($class);

        if (!$constructor = $reflector->getConstructor()) {
            return $reflector->newInstance();
        }

        $dependencies = array_map(
            fn($param) => $this->get($param->getType()?->getName() ?? ''),
            $constructor->getParameters()
        );

        return $reflector->newInstanceArgs($dependencies);
    }
}

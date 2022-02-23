<?php
namespace Winnipass\Wfx\App\Helpers;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class Container implements ContainerInterface {

    private array $entries = [];

    public function get(string $id) 
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }
        return $this->resolve($id);
    }

    public function has(string $id): bool {
        return false;
    }

    public function set(string $id, callable $concrete) {
        $this->entries[$id] = $concrete;
    }

    private function resolve(string $id) {
        $reflectionClass = new ReflectionClass($id);
        if (! $reflectionClass->isInstantiable()) {
            throw new Exception("Class {$id} is not instantiable", 400);
        }

        $constructor = $reflectionClass->getConstructor();
        if (! $constructor) {
            return $reflectionClass->newInstance();
        }

        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return $reflectionClass->newInstance();
        }

        $dependencies = array_map(function(ReflectionParameter $param) use($id) {
            $name = $param->getName();
            $type = $param->getType();

            if (! $type) {
                throw new Exception("Failed resolving class {$id} because param {$name} is missing a type hint");
            }

            if ($type instanceof ReflectionUnionType) {
                throw new Exception("Failed resolving class {$id} because of union type for param {$name}");
            }

            if ($type instanceof ReflectionNamedType && ! $type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new Exception("Failed resolving class {$id} because of invalid param {$name}");
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
<?php
namespace Winnipass\Wfx\App\Helpers;

use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\Collection;

class Helper {
    const CONTROLLER_PATH = 'Winnipass\Wfx\App\Controllers';

    const ABSTRACT_CONTROLLER_NAME = 'abstract';

    const REQUEST_METHOD_TO_CONTROLLER_ACTIONS_MAPPING = [
        'GET' => 'index',
        'POST' => 'create',
        'PUT' => 'update',
        'DELETE' => 'delete' 
    ];

    const AMOUNT_CONVERSION_VALUE = 100;

    public static function resolveResourceControllerNamespaces(array $namspaces, string $resource): string|false
    {
        $controllerPath = (new Collection($namspaces))
            ->filter(function ($value, $key) use($resource) {
                $controllerPath = strtolower($value);
                return !str_contains($controllerPath, self::ABSTRACT_CONTROLLER_NAME) 
                        && str_contains($controllerPath, $resource);
            })->values()->first();
        
        if ($controllerPath) {
            return (string)$controllerPath;
        }

        return false;
    }

    public static function getControllerClasses(): array
    {
        return ClassFinder::getClassesInNamespace(self::CONTROLLER_PATH);
    }
}
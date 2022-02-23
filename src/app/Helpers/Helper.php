<?php
namespace Winnipass\Wfx\App\Helpers;

use Illuminate\Support\Collection;

class Helper {
    const CONTROLLER_PATH = 'Winnipass\Wfx\App\Controllers';

    const ABSTRACT_CONTROLLER_NAME = 'abstract';

    public static function resolveResourceControllerNamespaces(array $namspaces, string $resource)
    {
        return (new Collection($namspaces))
            ->filter(function ($value, $key) use($resource) {
                $controllerPath = strtolower($value);
                return !str_contains($controllerPath, self::ABSTRACT_CONTROLLER_NAME) 
                        && str_contains($controllerPath, $resource);
            })->values()->first();
    }
}
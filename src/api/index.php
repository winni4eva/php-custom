<?php
require "../../bootstrap.php";

use HaydenPierce\ClassFinder\ClassFinder;
use Winnipass\Wfx\App\Helpers\Helper;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
[$firstPart, $apiPart, $resourcePart] = explode( '/', $uri );

if ($apiPart !== 'api') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if (str_ends_with($resourcePart, 's')) {
    $resourcePart = substr($resourcePart, 0, -1);
}

$controllerClasses = ClassFinder::getClassesInNamespace(Helper::CONTROLLER_PATH);
$resourceControllerPath = Helper::resolveResourceControllerNamespaces($controllerClasses, $resourcePart);

if (!$resourceControllerPath) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
var_dump($resourceControllerPath);
var_dump($requestMethod);

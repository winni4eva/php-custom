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

$controllerClasses = ClassFinder::getClassesInNamespace(Helper::CONTROLLER_PATH);
var_dump($controllerClasses);
//if (str_contains($uri, 'api'))

$requestMethod = $_SERVER["REQUEST_METHOD"];

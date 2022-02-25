<?php
require "../../bootstrap.php";

use Winnipass\Wfx\App\Helpers\Container;
use Winnipass\Wfx\App\Helpers\Helper;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/**
 * TODO validate request credentials 
 * 
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
@[$firstPart, $apiPart, $resourcePart, $resourceId] = explode( '/', $uri );

/**
 * TODO Filter request data for malicious scripts
 * 
 */

if ($apiPart !== 'api') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if (str_ends_with($resourcePart, 's')) {
    $resourcePart = substr($resourcePart, 0, -1);
}

$controllerClasses = Helper::getControllerClasses();
$resourceControllerPath = Helper::resolveResourceControllerNamespaces($controllerClasses, $resourcePart);

if (! class_exists($resourceControllerPath)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$method = Helper::REQUEST_METHOD_TO_CONTROLLER_ACTIONS_MAPPING[$requestMethod];

if (! method_exists($resourceControllerPath, $method)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$controller = (new Container())->get($resourceControllerPath);
$response = null;

/**
 * TODO request data validation
 * 
 */

switch ($requestMethod) {
    case 'GET':
        $response = call_user_func([$controller, $method], [$resourceId ?? null]);
        break;
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if ($resourceId) {
            $response = call_user_func([$controller, $method], [$resourceId, $input]);
        } else {
            $response = call_user_func([$controller, $method], [$input]);
        }
        break;
    default:
        $response = [['message' => 'Could not handle request properly'], 400];
        break;
}
$message = '';
$statusCode = 0;

if ($response) {
    [$message, $statusCode] = $response;
} else {
    [$message, $statusCode] = [['message' => 'Could not handle request properly'], 400];
}

header('Content-Type: application/json; charset=utf-8');
http_response_code($statusCode);
echo json_encode($message);

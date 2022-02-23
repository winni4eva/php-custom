<?php
require 'vendor/autoload.php';

use Winnipass\Wfx\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$dbConnection = (new Database())->connet();
var_dump($dbConnection);
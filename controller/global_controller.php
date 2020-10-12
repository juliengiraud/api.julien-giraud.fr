<?php

require_once('../config/config.php');
require_once(PATH_SERVICE . '/HeaderService.php');

if (DEBUG === true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$headerService = new HeaderService();
$path = explode('/', $_GET['path']);

if ($headerService->getContinue()) {
    switch ($path[0]) {

        case 'comptes':
            require_once('./comptes_controller.php');
            break;

        case 'test':
            require_once('./test_controller.php');
            break;

        default:
            http_response_code(404);
    }
}

$headerService->returnHttpErrorResponseIfNeeded();

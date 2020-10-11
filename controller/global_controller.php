<?php

require_once('../config/config.php');

if (DEBUG === true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$path = explode('/', $_GET['path']);

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

if (http_response_code() === 404) {
    echo json_encode(
        array(
            'success' => false,
            'message' => 'The requested URL was not found on this server',
            'error' => 'NOT_FOUND'
        )
    );
}

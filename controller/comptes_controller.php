<?php

require_once(PATH_SERVICE . '/UserService.php');

$userService = new UserService();

switch ($path[1]) {

    case 'login':
        $userDTO = json_decode(
            file_get_contents('php://input')
        );
        $result = $userService->login($userDTO);
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    case 'register':
        $userDTO = json_decode(
            file_get_contents('php://input')
        );
        $result = $userService->register($userDTO);
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    default:
        http_response_code(404);
}

<?php

require_once(PATH_SERVICE . "/UserService.php");
require_once(PATH_DTO . "/UserDTO.php");

$userService = new UserService();

switch ($path[1]) {

    case "login":
        $result = $userService->login(UserDTO::fromRequestBody());
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    case "register":
        $result = $userService->register(UserDTO::fromRequestBody());
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    default:
        http_response_code(404);
}

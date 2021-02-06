<?php

require_once(PATH_SERVICE . "/OperationService.php");
require_once(PATH_SERVICE . "/UserService.php");
require_once(PATH_DTO . "/UserDTO.php");

$userService = new UserService();
$operationService = new OperationService();

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

    case "getAllOperations":
        $loggedUser = $userService->getActiveUser();
        $result = $operationService->getAllOperations($loggedUser);
        if ($result !== null) {
            print json_encode($result);
        }
        break;
}

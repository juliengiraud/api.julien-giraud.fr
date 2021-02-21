<?php

require_once(PATH_SERVICE . "/OperationService.php");
require_once(PATH_SERVICE . "/UserService.php");
require_once(PATH_DTO . "/UserDTO.php");
require_once(PATH_DTO . "/OperationDTO.php");

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

    case "getByStartAndQuantity":
        if (isset($_GET['start']) && isset($_GET['length'])) {
            $start = $_GET['start'];
            $length = $_GET['length'];
        } else {
            http_response_code(400);
            HeaderService::$errorMessage = "Bad parameters.";
            break;
        }
        $loggedUser = $userService->getActiveUser();
        $result = $operationService->getByStartAndQuantity($loggedUser, $start, $length);
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    case "update":
        $loggedUser = $userService->getActiveUser();
        $operation = OperationDTO::fromRequestBody();
        if ($operation->getId() === null) {
            http_response_code(422);
            break;
        }
        $result = $operationService->update($loggedUser, $operation);
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    case "create":
        $loggedUser = $userService->getActiveUser();
        $result = $operationService->create($loggedUser, OperationDTO::fromRequestBody());
        if ($result !== null) {
            print json_encode($result);
        }
        break;

    case "delete":
        $loggedUser = $userService->getActiveUser();
        if (!@$_GET['id']) {
            http_response_code(422);
            break;
        }
        $result = $operationService->delete($loggedUser, $_GET['id']);
        if ($result !== null) {
            print json_encode($result);
        }
        break;
}

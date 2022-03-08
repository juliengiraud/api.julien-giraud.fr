<?php

require_once("../config/config.php");
require_once(PATH_SERVICE . "/HeaderService.php");

$headerService = new HeaderService();
$path = explode("/", $_GET["path"]);

if ($headerService->getContinue()) {

    switch ($path[0]) {

        case "comptes":
            require_once("./comptes_controller.php");
            break;

        case "stats":
            require_once("./stats_controller.php");
            break;

        case "test":
            require_once("./test_controller.php");
            break;
    }
}

$headerService->returnHttpErrorResponseIfNeeded();

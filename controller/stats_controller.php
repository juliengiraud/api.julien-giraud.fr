<?php

require_once(PATH_SERVICE . "/VisitService.php");

$visitService = new VisitService();

switch ($path[1]) {

    case "getAllPagesViewCount":
        echo json_encode(
            $visitService->getAllPagesViewCount()
        );
        break;
}

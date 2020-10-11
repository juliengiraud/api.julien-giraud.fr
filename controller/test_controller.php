<?php

require_once(PATH_SERVICE . '/VisitService.php');

$visitService = new VisitService();

switch ($path[1]) {

    case 'db':
        var_dump($visitService->getAllVisits());
        break;

    case 'fridrich-download':
        print($visitService->getPageViewCount('guide-methode-fridrich'));
        break;

    case 'fridrich-view':
        print($visitService->getPageViewCount('formation-rubiks-cube'));
        break;

    default:
        http_response_code(404);
}

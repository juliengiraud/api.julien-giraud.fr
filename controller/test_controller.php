<?php

require_once(PATH_SERVICE . '/VisitService.php');
require_once(PATH_SERVICE . '/TokenService.php');

$visitService = new VisitService();
$tokenService = new TokenService();

switch ($path[1]) {

    case 'getAllVisits':
        $visits = $visitService->getAllVisits();
        echo json_encode($visits);
        break;

    case 'getFridrichDownloadCount':
        $count = $visitService->getPageViewCount('guide-methode-fridrich');
        echo json_encode($count);
        break;

    case 'getFridrichViewCount':
        $count = $visitService->getPageViewCount('formation-rubiks-cube');
        echo json_encode($count);
        break;

    case 'getNewBearerToken':
        $token = $tokenService->generateNewToken();
        echo json_encode(array(
            'newToken' => $token
        ));
        break;

    default:
        http_response_code(404);
}

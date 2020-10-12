<?php

require_once(PATH_SERVICE . '/VisitService.php');
require_once(PATH_SERVICE . '/TokenService.php');

$visitService = new VisitService();
$tokenService = new TokenService();

switch ($path[1]) {

    case 'db':
        var_dump($visitService->getAllVisits());
        break;

    case 'fridrich-download':
        echo $visitService->getPageViewCount('guide-methode-fridrich');
        break;

    case 'fridrich-view':
        echo $visitService->getPageViewCount('formation-rubiks-cube');
        break;

    case 'bearer':
        $token = $tokenService->generateRandomString(64);
        echo json_encode(array(
            'newToken' => $token
        ));
        break;

    default:
        http_response_code(404);
}

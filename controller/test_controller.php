<?php

require_once(PATH_SERVICE . '/VisitService.php');
require_once(PATH_SERVICE . '/TokenService.php');

$visitService = new VisitService();
$tokenService = new TokenService();

switch ($path[1]) {

    default:
        http_response_code(404);
}

<?php

switch ($path[1]) {

  case 'login':
        print json_encode(array(
            'path' => 'register',
            'get' => $_GET,
            'data' => json_decode(file_get_contents('php://input'))
        ));
        break;

  case 'register':
        print json_encode(array(
            'path' => 'register',
            'get' => $_GET,
            'data' => json_decode(file_get_contents('php://input'))
        ));
        break;

  default:
        http_response_code(404);
}

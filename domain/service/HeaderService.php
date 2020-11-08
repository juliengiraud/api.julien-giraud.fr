<?php

require_once(PATH_SERVICE . '/TokenService.php');

class HeaderService {

    private $continue;
    private $tokenService;
    public static $errorMessage; // TODO implémenter un singleton

    public function __construct() {

        // Initialize variables
        $this->continue = false;
        HeaderService::$errorMessage = null;
        $this->tokenService = new TokenService();

        // Start service functions
        $this->initService();
    }

    // public function setErrorMessage($message) {
    //     $this->errorMessage = $message;
    // }

    private function initService() {

        // Set headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Content-Type: application/json; charset=UTF-8');

        // Always exit with 200 code status for OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        // Check authorization
        $path = explode('/', $_GET['path']);
        if ($this->tokenService->isTokenAuthorizationValid()
                // We can access to some URL without token
                || $path[0] === 'test' // -> /test
                || $path[0] === 'comptes' && ($path[1] === 'login' // -> /comptes/login
                    || $path[1] === 'register') // -> /comptes/register
        ) {
            $this->continue = true;
        } else {
            http_response_code(401);
            HeaderService::$errorMessage = 'Invalid token.';
        }
    }

    public function getContinue() {
        return $this->continue;
    }

    public function returnHttpErrorResponseIfNeeded() {
        $response = null;

        switch(http_response_code()) {
            case 401:
                $response = [
                    'success' => false,
                    'message' => HeaderService::$errorMessage,
                    'error' => 'UNAUTHORIZED'
                ];
                break;

            case 404:
                $response = [
                    'success' => false,
                    'message' => 'The requested URL was not found on this server.',
                    'error' => 'NOT_FOUND'
                ];
                break;
        }

        if ($response !== null) {
            echo json_encode($response);
        }
    }

}

<?php

require_once(PATH_SERVICE . '/TokenService.php');

class HeaderService {

    private $continue;
    private $tokenService;

    public function __construct() {

        // Initialize variables
        $this->continue = false;
        $this->tokenService = new TokenService();

        // Start service functions
        $this->initService();
    }

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

        // Check token
        if ($this->tokenService->isTokenAuthorizationValid()) {
            $this->continue = true;
        } else {
            http_response_code(401);
        }
    }

    public function getContinue() {
        return $this->continue;
    }

    public function returnHttpErrorResponseIfNeeded() {
        $response = null;

        switch(http_response_code()) {
            case 401:
                $response = array(
                    'success' => false,
                    'message' => 'Invalid token.',
                    'error' => 'UNAUTHORIZED'
                );
                break;

            case 404:
                $response = array(
                    'success' => false,
                    'message' => 'The requested URL was not found on this server.',
                    'error' => 'NOT_FOUND'
                );
                break;
        }

        if ($response !== null) {
            echo json_encode($response);
        }
    }

}

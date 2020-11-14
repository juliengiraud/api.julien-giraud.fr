<?php

require_once(PATH_SERVICE . "/TokenService.php");

class HeaderService {

    private $continue;
    private $tokenService;
    public static $errorMessage; // TODO implémenter un singleton
    public static $errorName; // TODO implémenter un singleton

    public function __construct() {

        // Initialize variables
        $this->continue = false;
        HeaderService::$errorMessage = null;
        $this->tokenService = new TokenService();

        // Start service functions
        $this->initService();
    }

    private function initService(): void {
        // Set headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Content-Type: application/json; charset=UTF-8");

        // Always exit with 200 code status for OPTIONS request
        if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
            exit(0);
        }

        // Check authorization
        $path = explode("/", $_GET["path"]);
        if ($this->tokenService->isTokenAuthorizationValid()
                // We can access to some URL without token
                || $path === ["test"]
                || $path === ["comptes", "login"]
                || $path === ["comptes", "register"]
        ) {
            $this->continue = true;
        } else {
            http_response_code(401);
            HeaderService::$errorMessage = "Invalid token.";
        }
    }

    public function getContinue(): bool {
        return $this->continue;
    }

    public function returnHttpErrorResponseIfNeeded(): void {
        $response = null;

        switch(http_response_code()) {
            case 401:
                $response = [
                    "success" => false,
                    "message" => HeaderService::$errorMessage,
                    "error" => HeaderService::$errorName ?? "UNAUTHORIZED"
                ];
                break;

            case 403:
                $response = [
                    "success" => false,
                    "message" => HeaderService::$errorMessage,
                    "error" => HeaderService::$errorName ?? "ALREADY_EXISTS"
                ];
                break;

            case 404:
                $response = [
                    "success" => false,
                    "message" => "The requested URL was not found on this server.",
                    "error" => "NOT_FOUND"
                ];
                break;

            case 422:
                $response = [
                    "success" => false,
                    "message" => "The request is missing a required parameter.",
                    "error" => "UNPROCESSABLE_ENTITY"
                ];
                break;
        }

        if ($response !== null) {
            echo json_encode($response);
        }
    }

}

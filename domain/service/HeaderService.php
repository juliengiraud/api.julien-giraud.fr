<?php

require_once(PATH_SERVICE . "/TokenService.php");
require_once(PATH_SERVICE . "/UserService.php");

class HeaderService {

    private $continue;
    public static $errorMessage;
    public static $errorName; // TODO implémenter un singleton
    private $userService;

    private $routes = [
        "comptes" => [
            "login" => ["auth" => false, "admin" => false],
            "register" => ["auth" => false, "admin" => false],
            "getByStartAndQuantity" => ["auth" => true, "admin" => false],
        ],
        "stats" => [
            "getAllPagesViewCount" => ["auth" => true, "admin" => true],
        ],
        "test" => []
    ];

    public function __construct() {

        // Initialize variables
        $this->continue = false;
        HeaderService::$errorMessage = null;
        $this->tokenService = new TokenService();
        $this->userService = new UserService();

        // Start service functions
        $this->initService();
        $this->checkRights();
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
    }

    private function checkRights() {
        $path = explode("/", $_GET["path"]);
        $right = $this->routes;
        foreach ($path as $node) {
            if (isset($right[$node])) {
                $right = $right[$node];
            }
        }
        if (!isset($right["auth"]) || !isset($right["admin"])) {
            http_response_code(404);
            return;
        }

        $user = $this->userService->getActiveUser();
        if ($right["auth"] && $user == null) {
            http_response_code(401);
            HeaderService::$errorMessage = "Invalid token.";
            return;
        }
        if ($right["admin"] && !$user->isAdmin()) {
            http_response_code(403);
            HeaderService::$errorMessage = "Invalid permissions.";
            return;
        }

        $this->continue = true;
    }

    public function getContinue(): bool {
        return $this->continue;
    }

    public function returnHttpErrorResponseIfNeeded(): void {
        $response = null;

        switch(http_response_code()) {
            case 400:
                $response = [
                    "success" => false,
                    "message" => HeaderService::$errorMessage,
                    "error" => HeaderService::$errorName ?? "BAD_REQUEST"
                ];
                break;

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
                    "error" => HeaderService::$errorName ?? "FORBIDDEN"
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

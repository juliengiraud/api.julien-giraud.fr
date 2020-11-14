<?php

require_once(PATH_DAO . "/VisitDAO.php");
require_once(PATH_MODEL . "/Visit.php");

class VisitService {

    private $visitDAO;

    public function __construct() {
        $this->visitDAO = new VisitDAO();
    }

    public function saveCurrentVisit(): void {
        // We first check if it's a real visit
        if ($_SERVER["REDIRECT_STATUS"] === "404" // 404 errors
                || preg_match("/bot|crawl|spider|search/i", $_SERVER["HTTP_USER_AGENT"]) // Bots
                || preg_match("/preprod/", $_SERVER["SCRIPT_URI"]) // My test server
                || preg_match("/^81.185.{4,8}/", $_SERVER["HTTP_REMOTE_IP"]) // Probably my IP
                || preg_match("/^2a01:cb14:4a2:a900:e944:8866:80bc:.{4}/", $_SERVER['HTTP_REMOTE_IP']) // Probably my IP too
        ) {
            return;
        }

        $visit = new Visit();
        $visit->setTarget($_SERVER["SCRIPT_URI"]);
        $visit->setIp($_SERVER["HTTP_REMOTE_IP"]);
        $visit->setUserAgent($_SERVER["HTTP_USER_AGENT"]);
        $this->visitDAO->create($visit);
    }

    public function getAllPagesViewCount(): array {
        return $this->visitDAO->getAllPagesViewCount();
    }

}

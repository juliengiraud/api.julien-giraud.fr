<?php

require_once(PATH_DAO . '/VisitDAO.php');
require_once(PATH_MODEL . '/Visit.php');

class VisitService {

    private $visitDAO;

    public function __construct() {
        $this->visitDAO = new VisitDAO();
    }

    public function saveCurrentVisit() {
        // We first check if it's a real visit
        if ($_SERVER['REDIRECT_STATUS'] === '404' // 404 errors
                || preg_match('/bot|crawl|spider|search/i', $_SERVER['HTTP_USER_AGENT']) // Bots
                || preg_match('/preprod/', $_SERVER['SCRIPT_URI']) // My test server
                || $_SERVER['HTTP_REMOTE_IP'] === '81.185.161.135' // My first ip
                || $_SERVER['HTTP_REMOTE_IP'] === '81.185.170.173' // My second ip
        ) {
            return;
        }

        $visit = new Visit();
        $visit->setTarget($_SERVER['SCRIPT_URI']);
        $visit->setIp($_SERVER['HTTP_REMOTE_IP']);
        $visit->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $this->visitDAO->saveOrUpdate($visit);
    }

    public function getAllVisits() {
        return $this->visitDAO->findAll();
    }

    public function getPageViewCount($page) {
        return $this->visitDAO->getPageViewCount($page);
    }

    public function getAllPagesViewCount() {
        return $this->visitDAO->getAllPagesViewCount();
    }

}

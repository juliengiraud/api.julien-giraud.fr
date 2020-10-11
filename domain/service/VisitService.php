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
                || preg_match('/bot|crawl|spider|search/', $_SERVER['HTTP_USER_AGENT'])) { // Bots
            return;
        }

        $visit = new Visit();
        $visit->setSource($_SERVER['HTTP_ORIGIN']);
        $visit->setTarget($_SERVER['SCRIPT_URI']);
        $visit->setIp($_SERVER['HTTP_REMOTE_IP']);
        $visit->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $visit->setParams($_SERVER['QUERY_STRING']);
        $this->visitDAO->saveOrUpdate($visit);
    }

    public function getAllVisits() {
        return $this->visitDAO->findAll();
    }

    public function getPageViewCount($page) {
        return $this->visitDAO->getPageViewCount($page);
    }

}

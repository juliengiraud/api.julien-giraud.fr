<?php

class Visit {

    private $id = null;
    private $source = null;
    private $target = null;
    private $ip = null;
    private $userAgent = null;
    private $params = null;
    private $date = null;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getTarget() {
        return $this->target;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function getUserAgent() {
        return $this->userAgent;
    }

    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }

    public function getParams() {
        return $this->params;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

}

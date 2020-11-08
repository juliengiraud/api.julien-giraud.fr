<?php

class Visit implements JsonSerializable {

    private $id = null;
    private $target = null;
    private $ip = null;
    private $userAgent = null;
    private $date = null;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
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

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'target' => $this->target,
            'ip' => $this->ip,
            'userAgent' => $this->userAgent,
            'date' => $this->date
        ];
    }

}

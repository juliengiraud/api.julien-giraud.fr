<?php

class Visit implements JsonSerializable {

    private $id;
    private $target;
    private $ip;
    private $userAgent;
    private $date;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getTarget() {
        return $this->target;
    }

    public function setTarget($target): void {
        $this->target = $target;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip): void {
        $this->ip = $ip;
    }

    public function getUserAgent() {
        return $this->userAgent;
    }

    public function setUserAgent($userAgent): void {
        $this->userAgent = $userAgent;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function jsonSerialize(): array {
        return [
            "id" => $this->id,
            "target" => $this->target,
            "ip" => $this->ip,
            "userAgent" => $this->userAgent,
            "date" => $this->date
        ];
    }

}

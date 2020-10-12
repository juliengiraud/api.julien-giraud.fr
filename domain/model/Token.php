<?php

class Token {

    private $id;
    private $token;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

}

<?php

class Token implements JsonSerializable {

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

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'login' => $this->token
        ];
    }

}

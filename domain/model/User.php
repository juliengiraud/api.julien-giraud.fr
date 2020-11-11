<?php

class User implements JsonSerializable {

    private $id;
    private $login;
    private $hashedPassword;
    private $token;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    public function setHashedPassword($hashedPassword) {
        $this->hashedPassword = $hashedPassword;
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
            'login' => $this->login,
            'token' => $this->token
        ];
    }

}

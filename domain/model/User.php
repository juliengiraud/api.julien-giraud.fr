<?php

class User {

    private $id;
    private $login;
    private $password;
    private $token;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

}

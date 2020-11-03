<?php

require_once(PATH_DAO . '/TokenDAO.php');

class TokenService {

    private const TOKEN_SIZE = 64;

    private $tokenDAO;

    public function __construct() {
        $this->tokenDAO = new TokenDAO();
    }

    public function isTokenAuthorizationValid() {
        $headerToken = $_SERVER["HTTP_AUTHORIZATION"];
        $tokenMethod = explode(' ', $headerToken)[0];
        if ($tokenMethod !== 'Bearer') {
            return false;
        }
        $token = explode(' ', $headerToken)[1];
        return $this->tokenDAO->isTokenValid($token);
    }

    public function generateNewToken() {
        do {
            $token = $this->generateRandomString();
        }
        while ($this->tokenDAO->isTokenValid($token));

        return $token;
    }

    private function generateRandomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < TokenService::TOKEN_SIZE; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

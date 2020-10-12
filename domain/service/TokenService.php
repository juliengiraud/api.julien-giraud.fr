<?php

require_once(PATH_DAO . '/TokenDAO.php');

class TokenService {

    private $tokenDAO;

    public function __construct() {
        $this->tokenDAO = new TokenDAO();
    }

    public function isTokenValid() {
        $headerToken = $_SERVER["HTTP_AUTHORIZATION"];
        $tokenMethod = explode(' ', $headerToken)[0];
        if ($tokenMethod !== 'Bearer') {
            return false;
        }
        $token = explode(' ', $headerToken)[1];
        return $this->tokenDAO->isTokenValid($token);
    }



    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

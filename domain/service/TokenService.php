<?php

require_once(PATH_DAO . "/TokenDAO.php");
require_once(PATH_MODEL . "/Token.php");
require_once(PATH_MODEL . "/User.php");

class TokenService {

    private const TOKEN_SIZE = 64;

    private $tokenDAO;

    public function __construct() {
        $this->tokenDAO = new TokenDAO();
    }

    public function isTokenAuthorizationValid(): bool {
        $headerToken = $_SERVER["HTTP_AUTHORIZATION"];
        $tokenMethod = explode(" ", $headerToken)[0];
        if ($tokenMethod !== "Bearer") {
            return false;
        }
        $token = explode(" ", $headerToken)[1];
        return $this->tokenDAO->isTokenKeyValid($token);
    }

    public function generateNewTokenKey(): string {
        do {
            $key = $this->generateRandomString();
        }
        while ($this->tokenDAO->isTokenKeyValid($key));

        return $key;
    }

    private function generateRandomString(): string {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < TokenService::TOKEN_SIZE; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getTokenFromUser(User $user): Token {
        return $this->tokenDAO->findOne($user->getTokenId());
    }

}

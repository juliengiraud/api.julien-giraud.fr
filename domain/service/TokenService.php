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
        return $this->tokenDAO->isTokenValid($token);
    }

    public function getToken() {
        $token = $this->getTokenString();
        if ($token === "") {
            return null;
        }
        return $this->tokenDAO->find($token);
    }

    private function getTokenString(): string {
        $headerToken = $_SERVER["HTTP_AUTHORIZATION"];
        $tokenMethod = explode(" ", $headerToken)[0];
        if ($tokenMethod !== "Bearer") {
            return "";
        }
        return explode(" ", $headerToken)[1];
    }

    public function generateNewToken(): Token {
        $newToken = new Token();
        do {
            $token = $this->generateRandomString();
        }
        while ($this->tokenDAO->isTokenFree($token));

        $newToken->setToken($token);
        $tokenId = $this->tokenDAO->create($newToken);

        return $this->tokenDAO->findOne($tokenId);
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

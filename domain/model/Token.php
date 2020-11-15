<?php

require_once(PATH_MODEL . "/FromObject.php");

class Token implements FromObject {

    private const LIFE_TIME = 14 * 24 * 3600; // 2 weeks
    private $id;
    private $token;
    private $creationDate;

    public function __construct() {
    }

    public static function fromObject($token) {
        $newToken = new Token();
        $newToken->id = $token->id;
        $newToken->token = $token->token;
        $newToken->creationDate = strtotime($token->creationDate);
        return $newToken;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function setToken($token): void {
        $this->token = $token;
    }

    public function getCreationDate(): string {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate): void {
        $this->creationDate = $creationDate;
    }

    public function isValid(): bool {
        return $this->creationDate + Token::LIFE_TIME >= time();
    }

}

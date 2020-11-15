<?php

require_once(PATH_MODEL . "/FromObject.php");

class Token implements JsonSerializable, FromObject {

    private $id;
    private $token;
    private $creationDate;
    private $expirationDate;

    public function __construct() {
    }

    public static function fromObject($token) {
        $newToken = new Token();
        $newToken->id = $token->id;
        $newToken->token = $token->token;
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

    public function getExpirationDate(): string {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate): void {
        $this->expirationDate = $expirationDate;
    }

    public function jsonSerialize(): array {
        return [
            "token" => $this->token
        ];
    }

}

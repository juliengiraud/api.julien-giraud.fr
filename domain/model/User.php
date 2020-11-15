<?php

require_once(PATH_MODEL . "/FromObject.php");

class User implements JsonSerializable, FromObject {

    private $id;
    private $login;
    private $hashedPassword;
    private $token;
    private $tokenId;

    public function __construct() {
    }

    public static function fromObject($user) {
        $newUser = new User();
        $newUser->id = $user->id;
        $newUser->login = $user->login;
        $newUser->hashedPassword = $user->hashedPassword;
        $newUser->tokenId = $user->tokenId;
        return $newUser;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function setLogin($login): void {
        $this->login = $login;
    }

    public function getHashedPassword(): string {
        return $this->hashedPassword;
    }

    public function setHashedPassword($hashedPassword): void {
        $this->hashedPassword = $hashedPassword;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token): void {
        $this->token = $token;
    }

    public function getTokenId() {
        return $this->tokenId;
    }

    public function setTokenId($tokenId): void {
        $this->tokenId = $tokenId;
    }

    public function jsonSerialize(): array {
        return [
            "id" => $this->id,
            "login" => $this->login,
            "token" => $this->token !== null ? $this->token->getToken() : null
        ];
    }

}

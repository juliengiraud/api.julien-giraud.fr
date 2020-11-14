<?php

class User implements JsonSerializable {

    private $id;
    private $login;
    private $hashedPassword;
    private $token;

    public function __construct() {
    }

    public static function fromObject(object $user) {
        $newUser = new User();
        $newUser->id = $user->id;
        $newUser->login = $user->login;
        $newUser->hashedPassword = $user->hashedPassword;
        $newUser->token = $user->token;
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

    public function getToken(): Token {
        return $this->token;
    }

    public function setToken($token): void {
        $this->token = $token;
    }

    public function jsonSerialize(): array {
        return [
            "id" => $this->id,
            "login" => $this->login,
            "token" => $this->token
        ];
    }

}

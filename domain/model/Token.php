<?php

class Token implements JsonSerializable {

    private $id;
    private $token;

    public function __construct() {
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

    public function jsonSerialize(): array {
        return [
            "id" => $this->id,
            "login" => $this->token
        ];
    }

}

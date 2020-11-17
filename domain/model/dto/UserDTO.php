<?php

require_once(PATH_DTO . "/RequestBody.php");

class UserDTO implements RequestBody {

    private $login;
    private $password;

    public static function fromRequestBody(): UserDTO {
        $input = json_decode(
            file_get_contents("php://input")
        );
        if (!isset($input->data) || !isset($input->data->login) || !isset($input->data->password)
                || $input->data->login === null || $input->data->password === null
                || $input->data->login === "" || $input->data->password === "") {
            http_response_code(422);
            return null;
        }

        $user = new UserDTO();
        $user->login = $input->data->login;
        $user->password = $input->data->password;

        return $user;
    }

    private function __construct() {
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function getPassword(): string {
        return $this->password;
    }

}

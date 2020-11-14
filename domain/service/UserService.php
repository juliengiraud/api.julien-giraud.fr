<?php

require_once(PATH_DAO . "/UserDAO.php");
require_once(PATH_DTO . "/UserDTO.php");
require_once(PATH_MODEL . "/User.php");

class UserService {

    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function login(UserDTO $userDTO) {
        if ($userDTO === null) {
            return null;
        }

        $user = $this->userDAO->getUserByLogin($userDTO->getLogin());

        if ($user === false || !password_verify($userDTO->getPassword(), $user->getHashedPassword())) {
            http_response_code(401);
            HeaderService::$errorMessage = "Bad login or password.";
            HeaderService::$errorName = "CONNECTION_FAILED";
            return null;
        }

        // TODO ajouter le token dans le user avant de le renvoyer
        return $user;
    }

    public function register(UserDTO $userDTO) {
        if ($userDTO === null) {
            return null;
        }

        $user = new User();
        $user->setLogin($userDTO->getLogin());
        $user->setHashedPassword(
            password_hash($userDTO->getpassword(), PASSWORD_DEFAULT)
        );

        if ($this->userDAO->isLoginUsed($user->getLogin())) {
            http_response_code(403);
            HeaderService::$errorMessage = "Login already exists.";
            HeaderService::$errorName = "USED_LOGIN";
            return null;
        }

        $user->setId($this->userDAO->create($user));
        // TODO ajouter le token dans le user avant de le renvoyer
        return $user;
    }

    private function updateToken(User $user): void {

    }

}

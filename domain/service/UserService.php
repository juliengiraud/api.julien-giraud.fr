<?php

require_once(PATH_DAO . '/UserDAO.php');
require_once(PATH_MODEL . '/User.php');

class UserService {

    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function login($userDTO) {
        $user = $this->userDAO->getUserByLogin($userDTO->login);

        if ($user === false || !password_verify($userDTO->password, $user->hashedPassword)) {
            http_response_code(401);
            HeaderService::$errorMessage = 'BAD_LOGIN_OR_PASSWORD';
            return null;
        }

        // TODO ajouter le token dans le user avant de le renvoyer
        return $user;
    }

    public function register($userDTO) {
        $user = new User();
        $user->setLogin($userDTO->login);
        $user->setHashedPassword(
            password_hash($userDTO->password, PASSWORD_BCRYPT)
        );

        if ($this->userDAO->isLoginUsed($user->getLogin())) {
            http_response_code(401);
            HeaderService::$errorMessage = 'USED_LOGIN';
            return null;
        }

        $user->setId($this->userDAO->create($user));
        // TODO ajouter le token dans le user avant de le renvoyer
        return $user;
    }

}

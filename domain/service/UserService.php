<?php

require_once(PATH_DAO . '/UserDAO.php');
require_once(PATH_MODEL . '/User.php');

class UserService {

    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function login($userDTO) {
        http_response_code(401);
        HeaderService::$errorMessage = 'ERROR_LOGIN';
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
        return $user;
    }

}

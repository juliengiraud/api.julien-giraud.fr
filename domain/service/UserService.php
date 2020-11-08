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
        http_response_code(401);
        HeaderService::$errorMessage = 'ERROR_REGISTER';
    }

}

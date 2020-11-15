<?php

require_once(PATH_DAO . "/UserDAO.php");
require_once(PATH_DTO . "/UserDTO.php");
require_once(PATH_MODEL . "/User.php");
require_once(PATH_SERVICE . "/HeaderService.php");
require_once(PATH_SERVICE . "/TokenService.php");

class UserService {

    private $userDAO;
    private $tokenService;

    public function __construct() {
        $this->userDAO = new UserDAO();
        $this->tokenService = new TokenService();
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

        $this->updateToken($user);
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
        $this->updateToken($user);
        return $user;
    }

    private function updateToken(User $user): void {
        // si l'utilisateur a un token et qu'il est encore valide on le charge
        // sinon (pas valide ou pas de token) on ajoute un nouveau token et on le charge
        if ($user->getTokenId() !== null) {
            $token = $this->tokenService->getTokenFromUser($user);
            $user->setToken($token);
        } else {
            var_dump($user);
        }
    }

}

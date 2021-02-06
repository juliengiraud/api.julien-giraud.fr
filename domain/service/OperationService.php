<?php

require_once(PATH_DAO . "/OperationDAO.php");
require_once(PATH_MODEL . "/Operation.php");
require_once(PATH_MODEL . "/User.php");

class OperationService {

    private $operationDAO;

    public function __construct() {
        $this->operationDAO = new OperationDAO();
    }

    public function getAllOperations(User $user): array {
        return $this->operationDAO->getAll($user->getId());
    }

}

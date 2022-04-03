<?php

require_once(PATH_DAO . "/OperationDAO.php");
require_once(PATH_MODEL . "/Operation.php");
require_once(PATH_MODEL . "/User.php");

class OperationService {

    private $operationDAO;

    public function __construct() {
        $this->operationDAO = new OperationDAO();
    }

    public function getByStartAndQuantity(User $user, int $start, int $length): array {
        return $this->operationDAO->get($user->getId(), $start, $length);
    }

    public function update(User $user, OperationDTO $operation): int {
        if ($user->isAdmin()) {
            return $this->operationDAO->rootUpdate($operation);
        }
        return $this->operationDAO->userUpdate($operation, $user);
    }

    public function create(User $user, OperationDTO $operation): int {
        return $this->operationDAO->create($operation, $user);
    }

    public function delete(User $user, $id): int {
        if ($user->isAdmin()) {
            return $this->operationDAO->rootDelete($id);
        }
        return $this->operationDAO->userDelete($id, $user);
    }

    public function getStats(User $user, int $year, int $month) {
        $userId = $user->getId();
        $fullMonth = strlen($month) > 1 ? $month : "0" + $month;
        return $this->operationDAO->getStats($userId, $year, $fullMonth);
    }

}

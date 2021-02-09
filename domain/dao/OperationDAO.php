<?php

require_once(PATH_DAO . "/AbstractGenericDAO.php");
require_once(PATH_MODEL . "/Operation.php");

class OperationDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function create(Operation $operation): int {
        $sql = "INSERT INTO comptes_operation (date, montant, commentaire, remboursable) VALUES (?, ?, ?, ?)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $operation->getDate(),
            $operation->getMontant(),
            $operation->getCommentaire(),
            $operation->isRemboursable()
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function update(Operation $operation): int {
        $sql = "UPDATE comptes_operation SET date = ?, montant = ?, commentaire = ?, remboursable = ? WHERE id = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $operation->getDate(),
            $operation->getMontant(),
            $operation->getCommentaire(),
            $operation->isRemboursable(),
            $operation->getId()
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function getOperationById(int $id): Operation {
        $sql = "SELECT * FROM comptes_operation WHERE id = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Operation");
        $query->execute([ $id ]);
        $operation = Operation::fromObject($query->fetch(PDO::FETCH_CLASS));
        return $operation;
    }

    public function get(int $userId, int $start, int $length): array {
        $sql = "SELECT * FROM comptes_operation WHERE userId = :userId ORDER BY date DESC limit :start, :length";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Operation");
        $query->bindParam(':userId', $userId, PDO::PARAM_STR);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':length', $length, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }

}

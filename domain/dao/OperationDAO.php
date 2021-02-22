<?php

require_once(PATH_DAO . "/AbstractGenericDAO.php");
require_once(PATH_MODEL . "/Operation.php");

class OperationDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function create(OperationDTO $operation, User $user): int {
        $date = $operation->getDate();
        $montant = $operation->getMontant();
        $commentaire = $operation->getCommentaire();
        $remboursable = $operation->isRemboursable();
        $userId = $user->getId();
        $sql = "INSERT INTO comptes_operation (
                    date, montant, commentaire, remboursable, userId
                ) VALUES (
                    :date, :montant, :commentaire, :remboursable, :userId
                )";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':montant', $montant, PDO::PARAM_STR);
        $query->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $query->bindParam(':remboursable', $remboursable, PDO::PARAM_BOOL);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $query->execute();
        return $this->getInstance()->db->lastInsertId();
    }

    public function rootUpdate(OperationDTO $operation): int {
        $date = $operation->getDate();
        $montant = $operation->getMontant();
        $commentaire = $operation->getCommentaire();
        $remboursable = $operation->isRemboursable();
        $id = $operation->getId();
        $sql = "UPDATE comptes_operation
                SET date = :date, montant = :montant, commentaire = :commentaire, remboursable = :remboursable
                WHERE id = :id";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':montant', $montant, PDO::PARAM_STR);
        $query->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $query->bindParam(':remboursable', $remboursable, PDO::PARAM_BOOL);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function userUpdate(OperationDTO $operation, User $user): int {
        $date = $operation->getDate();
        $montant = $operation->getMontant();
        $commentaire = $operation->getCommentaire();
        $remboursable = $operation->isRemboursable();
        $id = $operation->getId();
        $userId = $user->getId();
        $sql = "UPDATE comptes_operation
                SET date = :date, montant = :montant, commentaire = :commentaire, remboursable = :remboursable
                WHERE id = :id AND userId = :userId";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':montant', $montant, PDO::PARAM_STR);
        $query->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $query->bindParam(':remboursable', $remboursable, PDO::PARAM_BOOL);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $query->execute();
    }

    public function get(int $userId, int $start, int $length): array {
        $sql = "SELECT *
                FROM comptes_operation
                WHERE userId = :userId
                ORDER BY date DESC, id DESC
                LIMIT :start, :length";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Operation");
        $query->bindParam(':userId', $userId, PDO::PARAM_STR);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':length', $length, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    public function rootDelete(int $id): int {
        $sql = "DELETE FROM comptes_operation
                WHERE id = :id";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function userDelete(int $id, User $user): int {
        $userId = $user->getId();
        $sql = "DELETE FROM comptes_operation
                WHERE id = :id AND userId = :userId";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $query->execute();
    }

}

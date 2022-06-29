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

    public function getGlobalStats(int $userId): array {
        $sql = "select " .
        "(select sum(montant) from comptes_operation where userId = :userId) always_total, " .
        "(select sum(montant) from comptes_operation where userId = :userId and remboursable is false) always_personnal_total, " .
        "(select sum(montant) from comptes_operation where userId = :userId and montant > 0) always_total_input, " .
        "(select sum(montant) from comptes_operation where userId = :userId and montant < 0) always_total_output, " .
        "(select sum(montant) from comptes_operation where userId = :userId and remboursable is true) always_waiting_refund_output, " .
        "(select count(id) from comptes_operation where userId = :userId and remboursable is true) always_waiting_refund_count";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMonthStats(int $userId, int $year, int $month): array {
        $sql = "select " .
        "(select sum(montant) from comptes_operation where userId = :userId and year(date) = :year and month(date) = :month) month_total, " .
        "(select sum(montant) from comptes_operation where userId = :userId and year(date) = :year and month(date) = :month and remboursable is false) month_personnal_total, " .
        "(select sum(montant) from comptes_operation where userId = :userId and year(date) = :year and month(date) = :month and montant > 0) month_input, " .
        "(select sum(montant) from comptes_operation where userId = :userId and year(date) = :year and month(date) = :month and montant < 0) month_output, " .
        "(select sum(montant) from comptes_operation where userId = :userId and year(date) = :year and month(date) = :month and remboursable is true) month_waiting_refund_output, " .
        "(select count(id) from comptes_operation where userId = :userId and year(date) = :year and month(date) = :month and remboursable is true) month_waiting_refund_count, " .
        "(select sum(montant) from comptes_operation where userId = :userId and (year(date) < :year or year(date) = :year and month(date) <= :month)) month_total_since_always, " .
        "(select sum(montant) from comptes_operation where userId = :userId and year(date) = :year and month(date) <= :month) month_total_since_current_year";
        $query = $this->getInstance()->db->prepare($sql);
        $query->bindParam(':year', $year, PDO::PARAM_STR);
        $query->bindParam(':month', $month, PDO::PARAM_STR);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}

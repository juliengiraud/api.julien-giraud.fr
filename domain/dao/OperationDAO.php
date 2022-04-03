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

    public function getStats(int $userId, int $year, int $month): array {
        $sql = "select " .
        "(select sum(montant) from comptes_operation where year(date) = :year and month(date) = :month and userId = :userId) bilan_mois, " .
        "(select sum(montant) from comptes_operation where year(date) = :year and month(date) = :month and remboursable is false and userId = :userId) bilan_perso_mois, " .
        "(select sum(montant) from comptes_operation where year(date) = :year and month(date) = :month and montant > 0 and userId = :userId) entrees_mois, " .
        "(select sum(montant) from comptes_operation where year(date) = :year and month(date) = :month and montant < 0 and userId = :userId) sorties_mois, " .
        "(select sum(montant) from comptes_operation where year(date) = :year and month(date) = :month and remboursable is true and userId = :userId) du, " .
        "(select count(id) from comptes_operation where year(date) = :year and month(date) = :month and remboursable is true and userId = :userId) waiting_refund, " .
        "(select sum(montant) from comptes_operation where userId = :userId and (year(date) < :year or year(date) = :year and month(date) <= :month)) bilan_total ";
        $query = $this->getInstance()->db->prepare($sql);
        // $query->setFetchMode(PDO::FETCH_CLASS, "Operation");
        $query->bindParam(':year', $year, PDO::PARAM_STR);
        $query->bindParam(':month', $month, PDO::PARAM_STR);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Bilans généraux
    // Bilan total : 1533.95 €
    // Bilan perso : 1925.95 €
    // Total des entrées : 21140.22 €
    // Total des sorties : 19606.27 €
    // Total qu'on me doit : 392.00 €
    // Remboursements en attente : 4
    // select
    // (select sum(montant) from comptes_operation) "Bilan total", -- 1533.95 €
    // (select sum(montant) from comptes_operation where remboursable is false) "Bilan perso", -- 1925.95 €
    // (select sum(montant) from comptes_operation where montant > 0) "Total des entrées", -- 21140.22 €
    // (select sum(montant) from comptes_operation where montant < 0) "Total des sorties", -- 19606.27 €
    // (select sum(montant) from comptes_operation where remboursable is true) "Total qu'on me doit", -- 392.00 €
    // (select count(id) from comptes_operation where remboursable is true) "Remboursements en attente" -- 4

    // Bilans mensuels


}

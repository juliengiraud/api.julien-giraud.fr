<?php

require_once(PATH_DAO . "/AbstractGenericDAO.php");
require_once(PATH_MODEL . "/Visit.php");

class VisitDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function create($entity): int {
        $sql = "INSERT INTO visit (id, target, ip, userAgent) VALUES (?, ?, ?, ?)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $entity->getId(),
            $entity->getTarget(),
            $entity->getIp(),
            $entity->getUserAgent()
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function isLoginUsed(string $login): bool {
        $sql = "SELECT COUNT(*) value FROM comptes_user WHERE login = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $login ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== "0";
    }

    public function getAllPagesViewCount(): array {
        $sql = "SELECT target AS page, COUNT(target) AS count
                FROM visit
                WHERE target LIKE ?
                GROUP BY target
                ORDER BY COUNT(target) DESC";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ "https://www.julien-giraud.fr%" ]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}

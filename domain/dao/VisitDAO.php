<?php

require_once(PATH_DAO . '/AbstractGenericDAO.php');
require_once(PATH_MODEL . '/Visit.php');

class VisitDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function create($entity) {
        $sql = 'INSERT INTO visit (id, target, ip, userAgent) VALUES (?, ?, ?, ?)';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $entity->getId(),
            $entity->getTarget(),
            $entity->getIp(),
            $entity->getUserAgent()
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    /**
     * Return the number of visit for a specific page
     */
    public function getPageViewCount($page) {
        $sql = 'SELECT COUNT(*) value FROM visit WHERE target LIKE ?';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ '%'.$page.'%' ]);
        return $query->fetch(PDO::FETCH_OBJ)->value;
    }

    public function isLoginUsed($login) {
        $sql = 'SELECT COUNT(*) value FROM comptes_user WHERE login = ?';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $login ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== '0';
    }

    public function getAllPagesViewCount() {
        $query = "SELECT target AS page, COUNT(target) AS count
                  FROM visit
                  WHERE target LIKE 'https://www.julien-giraud.fr%'
                  GROUP BY target
                  ORDER BY COUNT(target) DESC";
        return $this->getInstance()->db->query($query)->fetchAll(PDO::FETCH_OBJ);
    }

}

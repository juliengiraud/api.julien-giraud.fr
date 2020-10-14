<?php

require_once(PATH_DAO . '/AbstractGenericDAO.php');
require_once(PATH_MODEL . '/Visit.php');

class VisitDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function findAll() {
        $query = 'SELECT * FROM visit ORDER BY id DESC';
        return $this->getInstance()->db->query($query)->fetchAll(PDO::FETCH_OBJ);
    }

    public function create($entity) {
        $sql = 'INSERT INTO visit (id, source, target, ip, userAgent, params) VALUES (?, ?, ?, ?, ?, ?)';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute(array( // Pas d'injection possible avec la source de l'objet Visit normalement
            $entity->getId(),
            $entity->getSource(),
            $entity->getTarget(),
            $entity->getIp(),
            $entity->getUserAgent(),
            $entity->getParams())
        );
        return $this->getInstance()->db->lastInsertId();
    }

    /**
     * Return the number of visit for a specific page
     */
    public function getPageViewCount($page) {
        $query = "SELECT COUNT(*) value FROM visit WHERE target LIKE '%" . $page . "%'";
        return $this->getInstance()->db->query($query)->fetch(PDO::FETCH_OBJ)->value;
    }

}

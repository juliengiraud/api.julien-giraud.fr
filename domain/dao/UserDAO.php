<?php

require_once(PATH_DAO . '/AbstractGenericDAO.php');
require_once(PATH_MODEL . '/User.php');

class UserDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    /**
     * Return true if login is already used
     *
     * @param login
     */
    public function isLoginUsed($login) {
        $sql = 'SELECT COUNT(*) value FROM comptes_user WHERE login = ?';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute(array(
            $login
        ));
        return $query->fetch(PDO::FETCH_OBJ)->value !== '0';
    }

    public function create($entity) {
        $sql = 'INSERT INTO comptes_user (login, hashedPassword) VALUES (?, ?)';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute(array(
            $entity->getLogin(),
            $entity->getHashedPassword()
        ));
        return $this->getInstance()->db->lastInsertId();
    }

}

<?php

require_once(PATH_DAO . "/AbstractGenericDAO.php");
require_once(PATH_MODEL . "/User.php");

class UserDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    /**
     * Return true if login is already used
     *
     * @param login
     */
    public function isLoginUsed($login): bool {
        $sql = "SELECT COUNT(*) value FROM comptes_user WHERE login = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $login ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== "0";
    }

    public function create($entity): int {
        $sql = "INSERT INTO comptes_user (login, hashedPassword) VALUES (?, ?)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $entity->getLogin(),
            $entity->getHashedPassword()
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function getUserByLogin($login): User {
        $sql = "SELECT * FROM comptes_user WHERE login = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "User");
        $query->execute([ $login ]);
        $user = User::fromObject($query->fetch(PDO::FETCH_CLASS));
        return $user;
    }

}

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
    public function isLoginUsed(string $login): bool {
        $sql = "SELECT COUNT(*) value FROM comptes_user WHERE login = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $login ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== "0";
    }

    public function create($entity): int {
        $sql = "INSERT INTO comptes_user (login, hashedPassword, admin) VALUES (?, ?, ?)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $entity->getLogin(),
            $entity->getHashedPassword(),
            $entity->isAdmin()
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function update(User $user): int {
        $sql = "UPDATE comptes_user SET login = ?, hashedPassword = ?, tokenId = ? WHERE id = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([
            $user->getLogin(),
            $user->getHashedPassword(),
            $user->getTokenId(),
            $user->getId(),
        ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function getUserByLogin(string $login): User {
        $sql = "SELECT * FROM comptes_user WHERE login = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "User");
        $query->execute([ $login ]);
        $user = User::fromObject($query->fetch(PDO::FETCH_CLASS));
        return $user;
    }

}

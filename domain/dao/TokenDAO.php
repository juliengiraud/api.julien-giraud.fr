<?php

require_once(PATH_DAO . "/AbstractGenericDAO.php");
require_once(PATH_MODEL . "/Token.php");
require_once(PATH_MODEL . "/User.php");

class TokenDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function isTokenFree(string $token): bool {
        $sql = "SELECT COUNT(*) value FROM comptes_token WHERE token = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $token ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== "0";
    }

    public function isTokenValid(string $token): bool {
        $sql = "SELECT COUNT(*) value
                FROM comptes_token t JOIN comptes_user u on t.id = u.tokenId
                WHERE token = ? and creationDate > date_sub(now(), interval 2 week)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $token ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== "0";
    }

    public function findOne(int $id) {
        $sql = "SELECT * FROM comptes_token WHERE id = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Token");
        $query->execute([ $id ]);
        $token = Token::fromObject($query->fetch(PDO::FETCH_CLASS));
        return $token;
    }

    public function create($token): int {
        $sql = "INSERT INTO comptes_token (token) VALUES (?)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $token->getToken() ]);
        return $this->getInstance()->db->lastInsertId();
    }

    public function find(string $token) {
        $sql = "SELECT * FROM comptes_token
                WHERE token = ? and creationDate > date_sub(now(), interval 2 week)";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Token");
        $query->execute([ $token ]);
        $token = Token::fromObject($query->fetch(PDO::FETCH_CLASS));
        return $token;
    }

}

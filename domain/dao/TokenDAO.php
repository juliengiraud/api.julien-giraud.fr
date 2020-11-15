<?php

require_once(PATH_DAO . "/AbstractGenericDAO.php");
require_once(PATH_MODEL . "/Token.php");
require_once(PATH_MODEL . "/User.php");

class TokenDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function isTokenKeyValid(string $key): bool {
        $sql = "SELECT COUNT(*) value FROM comptes_token WHERE token = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute([ $key ]);
        return $query->fetch(PDO::FETCH_OBJ)->value !== "0";
    }

    public function findOne(int $id): Token {
        $sql = "SELECT * FROM comptes_token WHERE id = ?";
        $query = $this->getInstance()->db->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Token");
        $query->execute([ $id ]);
        $token = Token::fromObject($query->fetch(PDO::FETCH_CLASS));
        return $token;
    }

}

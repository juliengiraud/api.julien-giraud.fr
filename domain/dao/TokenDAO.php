<?php

require_once(PATH_DAO . '/AbstractGenericDAO.php');
require_once(PATH_MODEL . '/Token.php');

class TokenDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function isTokenValid($token) {
        $query = "SELECT COUNT(*) value FROM comptes_token WHERE token = '" . $token . "'";
        return $this->getInstance()->db->query($query)->fetch(PDO::FETCH_OBJ)->value === '1';
    }

}

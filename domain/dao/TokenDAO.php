<?php

require_once(PATH_DAO . '/AbstractGenericDAO.php');
require_once(PATH_MODEL . '/Token.php');

class TokenDAO extends AbstractGenericDAO {

    public function __construct() {
    }

    public function isTokenValid($token) {
        $sql = 'SELECT COUNT(*) value FROM comptes_token WHERE token = ?';
        $query = $this->getInstance()->db->prepare($sql);
        $query->execute(array(
            $token
        ));
        return $query->fetch(PDO::FETCH_OBJ)->value !== '0';
    }

}

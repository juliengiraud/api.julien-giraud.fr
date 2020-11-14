<?php

class AbstractGenericDAO {

    private static $instance;
    protected $db;

    private function __construct() {
        if (!$settings = parse_ini_file(PATH_SETTING, TRUE)["database"]) {
            throw new exception("Unable to open or get settings from " . PATH_SETTING . ".");
        }
        $dns = $settings["driver"] . ":host=" . $settings["host"]
                . ((!empty($settings["port"])) ? (";port=" . $settings["port"]) : "")
                . "; dbname=" . $settings["dbname"]
                . "; charset=utf8";

        $this->db = new PDO($dns, $settings["username"], $settings["password"]);

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected static function getInstance(): AbstractGenericDAO {
        if (is_null(self::$instance)) {
            self::$instance = new AbstractGenericDAO();
        }
        return self::$instance;
    }

    /**
     * Return entity using its ID.
     *
     * @param id the entity ID
     */
    public function findOne(object $id): object {
        throw new Exception("Method not implemented");
    }

    /**
     * Return all entities as array
     *
     * @return array of entities
     */
    public function findAll(): array {
        throw new Exception("Method not implemented");
    }

    /**
     * Add new row in entity table
     */
    public function create(object $entity): int {
        throw new Exception("Method not implemented");
    }

    /**
     * Update row in entity table
     */
    public function update(object $entity): object {
        throw new Exception("Method not implemented");
    }

    /**
     * Delete entity from table
     */
    public function delete(object $entity): void {
        throw new Exception("Method not implemented");
    }

}

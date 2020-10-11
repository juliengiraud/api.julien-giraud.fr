<?php

class AbstractGenericDAO {

    private static $instance = null;
    protected $db = null;

    private function __construct() {
        if (!$settings = parse_ini_file(PATH_SETTING, TRUE)['database']) {
            throw new exception('Unable to open or get settings from ' . PATH_SETTING . '.');
        }
        $dns = $settings['driver'] . ':host=' . $settings['host']
                . ((!empty($settings['port'])) ? (';port=' . $settings['port']) : '')
                . '; dbname=' . $settings['dbname']
                . '; charset=utf8';

        $this->db = new PDO($dns, $settings['username'], $settings['password']);

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new AbstractGenericDAO();
        }
        return self::$instance;
    }

    /**
     * Return entity using its ID.
     *
     * @param id the entity ID
     * @return entity with matching ID
     */
    public function findOne($id) {
        throw new Exception('Method not implemented');
    }

    /**
     * Return all entities as array
     *
     * @return array of entities
     */
    public function findAll() {
        throw new Exception('Method not implemented');
    }

    /**
     * Add new row in entity table
     */
    public function create($entity) {
        throw new Exception('Method not implemented');
    }

    /**
     * Update row in entity table
     */
    public function update($entity) {
        throw new Exception('Method not implemented');
    }

    /**
     * Create entity if it does not exist, else update entity
     */
    public function saveOrUpdate($entity) {
        try {
            return $this->create($entity);
        } catch (Exception $e) {
            return $this->update($entity);
        }
    }

    /**
     * Delete entity from table
     */
    public function delete($entity) {
        throw new Exception('Method not implemented');
    }

}

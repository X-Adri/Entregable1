<?php
require_once __DIR__ . '/../config/database.php';

class DatabaseModel {
    protected $conn;
    protected $table_name;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    protected function executeQuery($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
}
?>
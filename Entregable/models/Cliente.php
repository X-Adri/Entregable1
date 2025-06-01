<?php
class Cliente extends DatabaseModel {
    protected $table_name = "clientes";
    
    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $empresa;
    public $direccion;
    public $created_at;

    public function __construct() {
        parent::__construct();
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre = :nombre, email = :email, telefono = :telefono, 
                      empresa = :empresa, direccion = :direccion";
        
        $params = [
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':empresa' => $this->empresa,
            ':direccion' => $this->direccion
        ];

        return $this->executeQuery($query, $params);
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, email = :email, telefono = :telefono,
                      empresa = :empresa, direccion = :direccion
                  WHERE id = :id";
        
        $params = [
            ':id' => $this->id,
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':empresa' => $this->empresa,
            ':direccion' => $this->direccion
        ];

        return $this->executeQuery($query, $params);
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->executeQuery($query, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        return $this->executeQuery($query, [':id' => $id]);
    }
}
?>
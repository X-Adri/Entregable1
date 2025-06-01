<?php
class Proyecto extends DatabaseModel {
    protected $table_name = "proyectos";
    
    public $id;
    public $nombre;
    public $descripcion;
    public $cliente_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $estado;
    public $presupuesto;
    public $created_at;

    public function __construct() {
        parent::__construct();
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre = :nombre, descripcion = :descripcion, cliente_id = :cliente_id,
                      fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, 
                      estado = :estado, presupuesto = :presupuesto";
        
        $params = [
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':cliente_id' => $this->cliente_id,
            ':fecha_inicio' => $this->fecha_inicio,
            ':fecha_fin' => $this->fecha_fin,
            ':estado' => $this->estado,
            ':presupuesto' => $this->presupuesto
        ];

        return $this->executeQuery($query, $params);
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, descripcion = :descripcion, cliente_id = :cliente_id,
                      fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin,
                      estado = :estado, presupuesto = :presupuesto
                  WHERE id = :id";
        
        $params = [
            ':id' => $this->id,
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':cliente_id' => $this->cliente_id,
            ':fecha_inicio' => $this->fecha_inicio,
            ':fecha_fin' => $this->fecha_fin,
            ':estado' => $this->estado,
            ':presupuesto' => $this->presupuesto
        ];

        return $this->executeQuery($query, $params);
    }

    public function obtenerTodos() {
        $query = "SELECT p.*, c.nombre as cliente_nombre, c.empresa 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN clientes c ON p.cliente_id = c.id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT p.*, c.nombre as cliente_nombre, c.empresa 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN clientes c ON p.cliente_id = c.id 
                  WHERE p.id = :id LIMIT 1";
        $stmt = $this->executeQuery($query, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        return $this->executeQuery($query, [':id' => $id]);
    }
}
?>
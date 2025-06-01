<?php
class ProyectoController {
    private $proyecto;
    private $cliente;

    public function __construct() {
        $this->verificarSesion();
        $this->proyecto = new Proyecto();
        $this->cliente = new Cliente();
    }

    private function verificarSesion() {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }

    public function index() {
        $proyectos = $this->proyecto->obtenerTodos();
        include __DIR__ . '/../views/proyecto/index.php';
    }

    public function crear() {
        $clientes = $this->cliente->obtenerTodos();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->proyecto->nombre = trim($_POST['nombre']);
            $this->proyecto->descripcion = trim($_POST['descripcion']);
            $this->proyecto->cliente_id = $_POST['cliente_id'];
            $this->proyecto->fecha_inicio = $_POST['fecha_inicio'];
            $this->proyecto->fecha_fin = $_POST['fecha_fin'];
            $this->proyecto->estado = $_POST['estado'];
            $this->proyecto->presupuesto = $_POST['presupuesto'];

            if ($this->proyecto->crear()) {
                header('Location: ' . BASE_URL . 'proyectos');
                exit();
            } else {
                $error = "Error al crear el proyecto";
            }
        }
        
        include __DIR__ . '/../views/proyecto/crear.php';
    }

    public function editar($id) {
        $proyecto = $this->proyecto->obtenerPorId($id);
        $clientes = $this->cliente->obtenerTodos();
        
        if (!$proyecto) {
            header('Location: ' . BASE_URL . 'proyectos');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->proyecto->id = $id;
            $this->proyecto->nombre = trim($_POST['nombre']);
            $this->proyecto->descripcion = trim($_POST['descripcion']);
            $this->proyecto->cliente_id = $_POST['cliente_id'];
            $this->proyecto->fecha_inicio = $_POST['fecha_inicio'];
            $this->proyecto->fecha_fin = $_POST['fecha_fin'];
            $this->proyecto->estado = $_POST['estado'];
            $this->proyecto->presupuesto = $_POST['presupuesto'];

            if ($this->proyecto->actualizar()) {
                header('Location: ' . BASE_URL . 'proyectos');
                exit();
            } else {
                $error = "Error al actualizar el proyecto";
            }
        }
        
        include __DIR__ . '/../views/proyecto/editar.php';
    }

    public function eliminar($id) {
        if ($this->proyecto->eliminar($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
?>
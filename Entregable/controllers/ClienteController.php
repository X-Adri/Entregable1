<?php
class ClienteController {
    private $cliente;

    public function __construct() {
        $this->verificarSesion();
        $this->cliente = new Cliente();
    }

    private function verificarSesion() {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }

    public function index() {
        $clientes = $this->cliente->obtenerTodos();
        include __DIR__ . '/../views/cliente/index.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cliente->nombre = trim($_POST['nombre']);
            $this->cliente->email = trim($_POST['email']);
            $this->cliente->telefono = trim($_POST['telefono']);
            $this->cliente->empresa = trim($_POST['empresa']);
            $this->cliente->direccion = trim($_POST['direccion']);

            if ($this->cliente->crear()) {
                header('Location: ' . BASE_URL . 'clientes');
                exit();
            } else {
                $error = "Error al crear el cliente";
            }
        }
        
        include __DIR__ . '/../views/cliente/crear.php';
    }

    public function editar($id) {
        $cliente = $this->cliente->obtenerPorId($id);
        
        if (!$cliente) {
            header('Location: ' . BASE_URL . 'clientes');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cliente->id = $id;
            $this->cliente->nombre = trim($_POST['nombre']);
            $this->cliente->email = trim($_POST['email']);
            $this->cliente->telefono = trim($_POST['telefono']);
            $this->cliente->empresa = trim($_POST['empresa']);
            $this->cliente->direccion = trim($_POST['direccion']);

            if ($this->cliente->actualizar()) {
                header('Location: ' . BASE_URL . 'clientes');
                exit();
            } else {
                $error = "Error al actualizar el cliente";
            }
        }
        
        include __DIR__ . '/../views/cliente/editar.php';
    }

    public function eliminar($id) {
        if ($this->cliente->eliminar($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
?>
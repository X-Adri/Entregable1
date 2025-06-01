<?php
require_once __DIR__ . '/../config/config.php';

// Obtener la ruta solicitada
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$path = str_replace('/proyecto_tecnosoluciones/public', '', $path);
$path = trim($path, '/');

// Si está vacío, redirigir al dashboard
if (empty($path)) {
    $path = 'dashboard';
}

// Dividir la ruta en segmentos
$segments = explode('/', $path);
$controller = $segments[0];
$action = isset($segments[1]) ? $segments[1] : 'index';
$id = isset($segments[2]) ? $segments[2] : null;

// Enrutamiento
switch ($controller) {
    case 'login':
        $authController = new AuthController();
        $authController->login();
        break;
        
    case 'register':
        $authController = new AuthController();
        $authController->register();
        break;
        
    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;
        
    case 'dashboard':
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
        include __DIR__ . '/../views/dashboard.php';
        break;
        
    case 'clientes':
        $clienteController = new ClienteController();
        if ($action === 'crear') {
            $clienteController->crear();
        } elseif ($action === 'editar' && $id) {
            $clienteController->editar($id);
        } elseif ($action === 'eliminar' && $id) {
            $clienteController->eliminar($id);
        } else {
            $clienteController->index();
        }
        break;
        
    case 'proyectos':
        $proyectoController = new ProyectoController();
        if ($action === 'crear') {
            $proyectoController->crear();
        } elseif ($action === 'editar' && $id) {
            $proyectoController->editar($id);
        } elseif ($action === 'eliminar' && $id) {
            $proyectoController->eliminar($id);
        } else {
            $proyectoController->index();
        }
        break;
        
    case 'reportes':
        $reporteController = new ReporteController();
        if ($action === 'clientes') {
            $reporteController->reporteClientes();
        } elseif ($action === 'proyectos') {
            $reporteController->reporteProyectos();
        }
        break;
        
    default:
        header('Location: ' . BASE_URL . 'login');
        break;
}
?>
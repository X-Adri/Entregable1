<?php
class AuthController {
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                $error = "Por favor, complete todos los campos";
            } else {
                $user = $this->usuario->login($username, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['logged_in'] = true;
                    header('Location: ' . BASE_URL . 'dashboard');
                    exit();
                } else {
                    $error = "Credenciales incorrectas";
                }
            }
        }
        
        include __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            if (empty($username) || empty($email) || empty($password)) {
                $error = "Por favor, complete todos los campos";
            } elseif ($password !== $confirm_password) {
                $error = "Las contraseñas no coinciden";
            } elseif (strlen($password) < 6) {
                $error = "La contraseña debe tener al menos 6 caracteres";
            } elseif ($this->usuario->existeUsuario($username, $email)) {
                $error = "El usuario o email ya existe";
            } else {
                $this->usuario->username = $username;
                $this->usuario->email = $email;
                $this->usuario->password = $password;
                
                if ($this->usuario->crear()) {
                    $success = "Usuario registrado exitosamente. Puede iniciar sesión.";
                } else {
                    $error = "Error al registrar el usuario";
                }
            }
        }
        
        include __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit();
    }
}
?>
<?php
class Usuario extends DatabaseModel {
    protected $table_name = "usuarios";
    
    public $id;
    public $username;
    public $email;
    public $password;
    public $created_at;

    public function __construct() {
        parent::__construct();
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username = :username, email = :email, password = :password";
        
        $params = [
            ':username' => $this->username,
            ':email' => $this->email,
            ':password' => password_hash($this->password, PASSWORD_DEFAULT)
        ];

        return $this->executeQuery($query, $params);
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->executeQuery($query, [':username' => $username]);
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    public function existeUsuario($username, $email) {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :email";
        $stmt = $this->executeQuery($query, [
            ':username' => $username,
            ':email' => $email
        ]);
        return $stmt->rowCount() > 0;
    }
}
?>
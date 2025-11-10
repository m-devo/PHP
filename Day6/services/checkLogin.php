<?php
class LoginManager {

    private $pdo; 

    public function __construct(PDO $pdo_connection) {
        $this->pdo = $pdo_connection;
    }

    public function authentication($username, $password) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        
        $stmt->execute([$username]);
        
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            return $user;
        }

        return false;
    }

}
?>
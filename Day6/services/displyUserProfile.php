<?php
class DisplyUserProfile {
    
    private $pdo; 

    public function __construct(PDO $pdo_connection) {
        $this->pdo = $pdo_connection;
    }

    public function fetchUserData(string $username): ?array {
        
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        
        $stmt->execute([$username]);
        
        $user = $stmt->fetch();

        if (!$user) {
            return null; 
        }

        if (!empty($user['skills'])) {
            $user['skills'] = json_decode($user['skills'], true);
        }
        
        return $user; 
    }
}
?>
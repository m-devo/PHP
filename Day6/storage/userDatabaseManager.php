<?php
require_once __DIR__ . "/userInterfaceManager.php";
class UserDatabaseManager implements UserManagerInterface {

    private $pdo;

    public function __construct(PDO $pdo_connection) {
        $this->pdo = $pdo_connection;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll();
        foreach ($users as $key => $user) {
            if (!empty($user["skills"])) {
                $users[$key]["skills"] = json_decode($user["skills"], true);
            }
        }
        return $users;
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        if ($user && !empty($user["skills"])) {
            $user["skills"] = json_decode($user["skills"], true);
        }
        return $user;
    }

    public function addUser($data) {
        $skillsJson = json_encode($data["skills"] ?? []);

        $sql = "INSERT INTO users 
                (firstName, lastName, email, sex, country, username, password, address, department, skills, profilePath, role) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            $data["firstName"],
            $data["lastName"],
            $data["email"],
            $data["sex"],
            $data["country"],
            $data["username"],
            $data["password"], 
            $data["address"],
            $data["department"],
            $skillsJson,
            $data["profilePath"],
            $data["role"] ?? "user"
        ]);
        
        return $this->pdo->lastInsertId();
    }


    public function updateUser($id, $data) {
        $skillsJson = json_encode($data["skills"] ?? []);

        $sql = "UPDATE users SET 
                firstName = ?, 
                lastName = ?, 
                email = ?, 
                sex = ?, 
                country = ?, 
                username = ?, 
                password = ?, 
                address = ?, 
                department = ?, 
                skills = ?, 
                profilePath = ?, 
                role = ? 
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            $data["firstName"],
            $data["lastName"],
            $data["email"],
            $data["sex"],
            $data["country"],
            $data["username"],
            $data["password"], 
            $data["address"],
            $data["department"],
            $skillsJson,
            $data["profilePath"],
            $data["role"],
            $id
        ]);
        
        return $stmt->rowCount() > 0;
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
?>
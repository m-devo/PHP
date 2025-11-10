<?php
class DisplyUserProfile {
    private $filename;

    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    private function readAllUsersData() {
        if (!file_exists($this->filename)) {
            return [];
        }
        $jsonString = file_get_contents($this->filename);
        $users = json_decode($jsonString, true);
        return is_array($users) ? $users : [];
    }

    public function fetchUserData(string $username): ?array {
        $users = $this->readAllUsersData(); 
        foreach ($users as $data) { 
            if (is_array($data) && isset($data["username"]) && $data["username"] === $username) {
                return $data; 
            }
        }
        
        return null; 
    }
}
?>
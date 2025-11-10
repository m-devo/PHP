<?php
class LoginManager {
    private $filename;
    private $userProfilePath;

    public function __construct($filename) {
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

    public function authentication($username, $password) {
        $users = $this->readAllUsersData();

        foreach ($users as $data) { 
            if (is_array($data) && isset($data["username"]) && isset($data["password"])) {
                if ($data["username"] === $username && password_verify($password, $data["password"])) {
                    if (isset($data["profilePath"])) {
                        $this->userProfilePath = $data["profilePath"];
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function getPicPath() {
        return $this->userProfilePath;
    }
}
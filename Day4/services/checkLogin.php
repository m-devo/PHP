<?php

class LoginManager{
    private $filename;
    private $userProfilePath;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    
    public function authentication($username, $password) {
        if(!file_exists($this->filename)) {
            return false;
        }
        $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $data = json_decode($line, true);
            
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
?>
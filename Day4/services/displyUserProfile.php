<?php
class DisplyUserProfile {
    private $filename;

    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    public function fetchUserData(string $username): ?array {
        if (!file_exists($this->filename)) {
            return null;
        }

        $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $data = json_decode($line, true);
            
            if (is_array($data) && isset($data["username"]) && $data["username"] === $username) {
                return $data; 
            }
        }
        
        return null; 
    }
}

?>
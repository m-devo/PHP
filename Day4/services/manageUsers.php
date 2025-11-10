<?php
class UserBoardManager {
    private $filename;

    public function __construct( $filename) {
        $this->filename = $filename;
    }

    public function getAllUsers() {
        if (!file_exists($this->filename)) {
            return [];
        }

        $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $users = [];
        
        foreach ($lines as $index => $line) {
            $data = json_decode($line, true);
            
            if (is_array($data)) {
                $data["line"] = $index; 
                $users[] = $data;
            }
        }
        return $users;
    }

    public function deleteUser($lineToDelete) {
        
        if (!file_exists($this->filename)) {
            return false;
        }

        $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        if (isset($lines[$lineToDelete])) {
            
            unset($lines[$lineToDelete]);
            file_put_contents($this->filename, implode(PHP_EOL, $lines) . PHP_EOL);
            return true;
        }
        return false;
    }
}
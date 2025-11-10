<?php
class UserBoardManager {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
        if (!file_exists($this->filename)) {
            file_put_contents($this->filename, "[]"); 
        }
    }

    private function readAllUsersData() {
        $jsonString = file_get_contents($this->filename);
        $users = json_decode($jsonString, true);
        return is_array($users) ? $users : [];
    }

    private function saveAllUsersData($users) {
        $usersToSave = array_values($users); 
        $jsonString = json_encode($usersToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->filename, $jsonString);
    }

    public function addUser($newData) {
        $users = $this->readAllUsersData(); 
        $users[] = $newData; 
        $this->saveAllUsersData($users); 
    }

    public function getAllUsers() {
        $users = $this->readAllUsersData();
        
        $userWithIndex = [];
        foreach ($users as $index => $user) {
            $user["index"] = $index; 
            $userWithIndex[] = $user;
        }
        return $userWithIndex;
    }


    public function deleteUser($userIndex) {
        $users = $this->readAllUsersData(); 
        
        if (isset($users[$userIndex])) {
            unset($users[$userIndex]); 
            $this->saveAllUsersData($users); 
            return true;
        }
        return false;
    }
    
    public function getUserByIndex($getIndex) {
        $users = $this->readAllUsersData();
        
        if (isset($users[$getIndex])) {
            $data = $users[$getIndex];
            $data["index"] = $getIndex; 
            return $data;
        }
        return null;
    }


    public function updateUser($updateByIndex, $newData) {
        $users = $this->readAllUsersData(); 

        if (isset($users[$updateByIndex])) {
            $users[$updateByIndex] = $newData; 
            $this->saveAllUsersData($users); 
            return true;
        }
        return false;
    }
}
?>
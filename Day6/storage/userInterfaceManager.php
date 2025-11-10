<?php

interface UserManagerInterface {

    public function getAllUsers();

    public function getUserById($id);

    public function addUser($data);

    public function updateUser($id, $data);

    public function deleteUser($id);
}
?>

<?php
class UserProfile {
    private $firstName;
    private $lastName;
    private $email;
    private $address;
    private $sex;
    private $country;
    private $username;
    private $passwordHash;  
    private $department;
    private $skills = []; 
    private $title = "";
    private $profilePicPath = "";

    public function __construct(array $data) {
        $this->firstName= $data["firstName"];
        $this->lastName= $data["lastName"];
        $this->email= $data["email"];
        $this->address= $data["address"];
        $this->sex= $data["sex"];
        $this->country= $data["country"];
        $this->username= $data["username"];
        $this->department= $data["department"];
        $this->skills= $data["skills"] ?? [];
        $this->title= $this->sex === "male" ? "Mr" : "Miss";
        $this->passwordHash = password_hash($data["password"], PASSWORD_DEFAULT);
    }

    public function setProfilePicPath(string $path) {
        $this->profilePicPath = $path;
    }

    public function getFirstName() { return $this->firstName; }
    public function getLastName()  { return $this->lastName; }
    public function getEmail()     { return $this->email; }
    public function getAddress()   { return $this->address; }
    public function getSex()       { return $this->sex; }
    public function getCountry()   { return $this->country; }
    public function getUsername()  { return $this->username; }
    public function getPasswordHash() { return $this->passwordHash; }
    public function getDepartment(){ return $this->department; }
    public function getSkills()    { return $this->skills; }
    public function getTitle()     { return $this->title; }
    public function getProfilePicPath() { return $this->profilePicPath; }
}

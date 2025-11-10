<?php 

class RegisterationValidator {
    private $data;
    private $files;
    private $errors = [];
    private $validatedData;

    public $targetFile = "";
    public $displayPath = "";

    public function __construct(array $data, array $files)
    {
        $this->data = $data;
        $this->files = $files;
    }

    private function validateRequiredData() {
        $data = array(
        "firstName",
        "lastName",
        "email",
        "address",
        "country", 
        "sex",
        "username", 
        "password", 
        "confirm_password", 
        "department"
    );
        foreach ($data as $requiredData){
            if(empty($this->data[$requiredData])) {
            $this->errors[] = "This '" . $requiredData . "' is required"; 
            }
        }        
    }

    private function validateUserName(){
        $pattern = "/^[a-zA-Z]+$/";
        $options = [ 'options' => [ 'regexp' => $pattern ] ];
        if (!empty($this->data["firstName"]) && filter_var($this->data["firstName"], FILTER_VALIDATE_REGEXP, $options) === false) {
            $this->errors[] = "First Name must be alphabets only";
        }
        if (!empty($this->data["lastName"]) && filter_var($this->data["lastName"], FILTER_VALIDATE_REGEXP, $options) === false) {
            $this->errors[] = "Second Name must be alphabets only";
        }

        if(!empty($this->data["username"]) && preg_match("/\s/",$this->data["username"] )) {
            $this->errors[] = "User name shouldn't have any spaces";
        };

    }

    private function validateEmail(){
        if (empty($this->data["email"]) || !filter_var($this->data["email"], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "This email format is not valid";
        }   
    }

    private function validatePassword(){
        if (!empty($this->data["password"]) && $this->data["password"] !== $this->data["confirm_password"]) {
            $this->errors[] = "Passwords do not match";
        }
        if (!empty($this->data["password"]) && strlen($this->data["password"]) !== 8) {
            $this->errors[] = "Password must be exactly 8 characters";
        }
        if (!empty($this->data["password"]) && !preg_match('/^[a-z0-9_]+$/', $this->data["password"])) {
            $this->errors[] = "Password must be lowercase letters, numbers, or underscore only";
        }
    }

    private function validateProfilePic(){
    if (isset($this->files["profile_pic"]) && $this->files["profile_pic"]["error"] == UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/../assets/images/";    
        $uploadDir_HTML = "/assets/images/";  
        
        $check = getimagesize($this->files["profile_pic"]["tmp_name"]);
        if($check === false) {
            $this->errors[] = "File is not an image.";
        } else {
            $extension = strtolower(pathinfo($this->files["profile_pic"]["name"], PATHINFO_EXTENSION));
            $safeName = time() . "_" . uniqid() . "." . $extension;
            $this->targetFile = $uploadDir . $safeName;

            $this->displayPath = $uploadDir_HTML . $safeName;
        }
    } else {
        $this->errors[] = "Profile picture is required";
    }

    }

    public function formValidation(){
        $this->validateRequiredData();
        $this->validateUserName();
        $this->validateEmail();
        $this->validatePassword();
        $this->validateProfilePic();

        if(empty($this->errors)) {
            $this->validatedData = $this->data;
        }
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getValidatedData() {
        return $this->validatedData;
    }
};
?>
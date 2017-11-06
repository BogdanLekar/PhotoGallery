<?php
class Validate {
    
    public $user;
    public $password;
    public $error = array('');
    
    public function validate_reg_user() {
            if(!preg_match("/^[a-zA-Z0-9_-]{3,16}$/", $this->user)){
                return false;
            } else {
                return $this->user;
            }
    }
    
    public function validate_reg_password() {
            if(!preg_match("/^[a-zA-Z0-9_-]{6,18}$/", $this->password)){
                return false;
            } else {
                return $this->password;
            }
    }
    
    public function chack_validate() {
        if($this->validate_reg_user() && $this->validate_reg_password()){
            return true;
        } 
    }
    
    public function validate_reg_folder_name() {
            if(!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_]+)$/u', $this->user)){
                return false;
            } else {
                return $this->user;
            }
    }
    
}

?>
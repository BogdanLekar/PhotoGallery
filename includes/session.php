<?php

class Session {
    
    private $logged_in=false;
    public $user_id;
    public $user_name;
    public $message;
    
    function __construct() {
        session_start();
        $this->check_message();
        $this->check_login();
    }
    
    public function is_logged_in() {
        return $this->logged_in;
    }
    
    public function login($user) {
        // Если в БД найден пользователь и он прошёл проверку выполняем вход
        if($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->user_name = $_SESSION['user_name'] = $user->username;
            $this->logged_in = true;
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($this->user_id);
        $this->logged_in = false;
    }
    
    // двойная функции - может как задавать так и получать значение сообщения set massage and get massage
    public function message($msg="") {
        if(!empty($msg)) {
            // then this is "set message"
            // make sure you understand why $this->message=$msg wouldn't work
            $_SESSION['message']= $msg;
        } else {
            // then this is "get message"
            return $this->message;
        }
    }
    
    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->user_name = $_SESSION['user_name'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            unset($this->user_name);
            $this->logged_in = false;
        }
    }
    
    private function check_message() {
        // Сообщене заданно в SESSION['message]
        if(isset($_SESSION['message'])) {
            // Добавить атрибут message и очистить сессию 
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
    
}

$session = new Session();
$message = $session->message();

?>
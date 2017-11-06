<?php require_once('../../includes/initialize.php'); ?>

<?php
if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

$users = User::find_all();
if(isset($_POST['submit'])) {
    if(!empty($_POST['name']) && !empty($_POST['password'])){
        $validate = new Validate();
        $validate->user = trim($_POST['name']);
        $validate->password = trim($_POST['password']);
        if($validate->chack_validate()) {
            $sql = "SELECT * FROM users ";
            $sql .= "WHERE username = '{$validate->user}' ";
            $result_array = User::find_by_sql($sql);
            if(!empty($result_array)) {
                $message = "Такое имя уже занято";
            } else {
                $user = new User();
                $user->username = $validate->user;
                $user->password = password_hash($validate->password, PASSWORD_DEFAULT);
                $user->first_name = $_POST['fname'];
                $user->last_name = $_POST['lname'];
                if($user->save()){
                    redirect_to("add_admin.php");
                } else {
                    echo "Сори";
                }
            }
            
        } else {
            $message = "Не правильный формат имени или пароля";
        }
    } else {
        $message = "Не все поля заполнены";
    }
    
}

?>

<?php include('view/add_admin.php');



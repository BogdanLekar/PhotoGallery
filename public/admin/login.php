<?php require_once('../../includes/initialize.php'); ?>

<?php

if($session->is_logged_in()) {
    redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Check database to see if username/password exist.
    $found_user = User::authenticate($username, $password);
    if ($found_user) {
        $action = "Авторизация ";
        $logger->log_action($action, $username);
        $session->login($found_user);
        redirect_to("index.php");
    } else {
        // username/password combo was not found in the database
        $message = "Логин или пароль не подходят.";
    }
} else { // Form has not been submitted.
    $message = "";
    $username = "";
    $password = "";
}

?>

<?php include('view/login.php');


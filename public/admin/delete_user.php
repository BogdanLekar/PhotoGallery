<?php require_once('../../includes/initialize.php'); ?>

<?php 

if (!$session->is_logged_in()) { redirect_to("login.php"); } 

// must have an ID
if(empty($_GET['id'])) {
    $session->message("ID пользователя не заданн.");
    redirect_to('add_admin.php');
}

$user = User::find_by_id($_GET['id']);
$user_id = $user->id;
if($user && $user->delete()) {
    $session->message("Пользователь {$user->username} улалён.");
    redirect_to("add_admin.php");
} else {
    $session->message("Пользователь не был удалён.");
    redirect_to('add_admin.php');
}

?>   
    
<?php if(isset($database)) { $database->close_connection(); } ?>

<?php require_once('../../includes/initialize.php'); ?>

<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>

<?php

// must have an ID
if(empty($_GET['id'])) {
    $session->message("ID папки небыло заданно.");
    redirect_to('index.php');
}

$folder = Subject::find_by_id($_GET['id']);
$photo =  Photograph::find_photo_on($_GET['id']);
if(empty($photo) && $folder->delete()) {
    $session->message("Папка {$folder->filename} удалена.");
    redirect_to('new_subject.php');
} else {
    $session->message("Папка не может быть удалена. Возможно в ней есть фотографии.");
    redirect_to('new_subject.php');
}

?>
       
<?php if(isset($database)) { $database->close_connection(); } ?>

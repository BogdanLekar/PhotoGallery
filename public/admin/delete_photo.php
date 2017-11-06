<?php require_once('../../includes/initialize.php'); ?>

<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>

<?php

// must have an ID
if(empty($_GET['id'])) {
    $session->message("ID фотографии не заданно.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
$comment =  Comment::find_comments_on($_GET['id']);
if($photo && $photo->destroy()) {
    $session->message("Фото {$photo->filename} удалено.");
    if($comment) {
        foreach($comment as $com){
            $com->delete();
        }
        
    }
    redirect_to('list_photos.php');
} else {
    $session->message("Фото не было удалено.");
    redirect_to('list_photos.php');
}

?>
       
<?php if(isset($database)) { $database->close_connection(); } ?>

<?php require_once('../../includes/initialize.php'); ?>

<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>

<?php

// must have an ID
if(empty($_GET['id'])) {
    $session->message("ID коментария не заданно.");
    redirect_to('index.php');
}

$comment = Comment::find_by_id($_GET['id']);
$photo_id = $comment->photograph_id;
if($comment && $comment->delete()) {
    $session->message("Коментарий {$comment->author} удалён.");
    redirect_to("comment_admin.php?photo_id={$photo_id}");
} else {
    $session->message("Коментарий не получилось удалить.");
    redirect_to('index.php');
}
?>
    
    
<?php if(isset($database)) { $database->close_connection(); } ?>

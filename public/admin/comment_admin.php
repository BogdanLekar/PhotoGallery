<?php require_once('../../includes/initialize.php'); ?>

<?php

if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

if(isset($_GET['photo_id']) && !empty($_GET['photo_id'])) {
    $photo = Photograph::find_by_id($_GET['photo_id']); 
    $comments = Comment::find_comments_on($_GET['photo_id']);
} else {
    $session->message("Не правельное расположение фото.");
    redirect_to("list_photos.php");
}
if(!$photo) {
    $session->message("Фото не было обнаружено.");
    redirect_to("list_photos.php");
} 

if(isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);
    
    $new_comment = Comment::make($photo->id, $author, $body);
    if($new_comment && $new_comment->save()) {
        // comment saved
        // No message needed; seeing the comment is proof enough.
        
        // Important! You could just let the page render from here.
        // But then if the page is reloaded, the form will try
        // to resubmit the comment. So redirect instead:
        $session->message("Коментарий был создан");
        redirect_to("comment_admin.php?photo_id={$photo->id}");
    } else {
        // Failed
        $message = "Была обнаружена ошибка при создании коментария.";
    }
} else {
    $author = "";
    $body = "";
}

?>

<?php include('view/comment_admin.php');


<?php require_once('../../includes/initialize.php'); ?>

<?php

if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

$max_file_size = 1048576;       // expressed in bytes
                                // 10240 = 10 KB
                                // 102400 = 100 KB
                                // 1048576 = 1 MB
                                // 10485760 = 10 MB

if(isset($_POST['submit'])) {
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];
    $photo->subject_id = $_POST['subject'];
    $photo->attach_file($_FILES['file_upload']);
    if($photo->save()) {
        // Success
        $session->message("Фото загружено успешно.");
        redirect_to('list_photos.php');
    } else {
        // Failure
        $message = join("<br>", $photo->errors);
    }
}

$subjects = Subject::find_all();

?>

<?php include('view/photo_upload.php');

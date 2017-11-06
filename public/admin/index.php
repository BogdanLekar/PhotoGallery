<?php require_once('../../includes/initialize.php'); ?>

<?php

if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

$photos = Photograph::find_all(); 

?>

<?php include('view/index.php');


<?php require_once('../../includes/initialize.php'); ?>

<?php

if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

if(isset($_GET['clear']) == 'true') {
    $logger->delite_log_file($session->user_name);
}

?> 

<?php include('view/logfile.php'); ?>



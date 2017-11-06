<?php require_once('../../includes/initialize.php'); ?>

<?php

if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

// Используем пагинацию вместо всех фото
//$photos = Photograph::find_all(); 
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$_SESSION['page'] = $page;
$per_page = 5;
$total_count = Photograph::count_all();

$pagination = new Pagination($page, $per_page, $total_count);
$photos = $pagination->find_pagination_photo();

?>

<?php include('view/list_photos.php');



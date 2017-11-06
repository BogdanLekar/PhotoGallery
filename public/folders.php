<?php require_once('../includes/initialize.php'); ?>

<?php

$subjects = Subject::find_all();

//$limit = 5;
//$subjects = Subject::find_limit($limit);

if(isset($_GET['subject_id']) && !empty($_GET['subject_id'])) {
    //$photos = Photograph::find_photo_on($_GET['subject_id']);
    
    ////Пагинация Фото
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $per_page = 2;
    $total_count = Photograph::count_all_element_by_subject_id($_GET['subject_id']);
    $pagination = new Pagination($page, $per_page, $total_count);
    $photos = $pagination->find_pagination_photo_by_subject($_GET['subject_id']);
}

?>

<?php include('view/folder.php'); ?>
<?php require_once('../../includes/initialize.php'); ?>

<?php

if (!$session->is_logged_in()) { 
    redirect_to("login.php"); 
}

if(isset($_POST['submit'])) {
    $validate = new Validate();
    $validate->user = trim($_POST['menu_name']);
    $menu_name = $validate->validate_reg_folder_name();
    if($menu_name) {
        $subject = new Subject;
        $subject->menu_name = $menu_name;
        $subject->visible = $_POST['visible'];
        if($subject->save()) {
            $session->message("Папка создана успешно.");
            redirect_to('new_subject.php');
        } else {
            $message = "Не получилось сохранить папку.";
        }
    } else {
        $message = "Имя для папки не подходит";
    }
}

$subjects = new Subject();
$subjects_object = $subjects->find_all();

?>

<?php include('view/new_subject.php');


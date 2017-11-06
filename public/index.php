<?php require_once('../includes/initialize.php'); ?>
<?php 
// !! Делаем Пагинацию
// 1. Номер страницы на котором находимся ($current_pate)
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
// 2. Количество записей на страницу($per_page)
$per_page = 3;

// 3. Общее количество записей ($total_count)
$total_count = Photograph::count_all();

// Find all photos
// Вместо этого метода мы будем использовать пагинацию
//$photos = Photograph::find_all(); 

$pagination = new Pagination($page, $per_page, $total_count);
$photos = $pagination->find_pagination_photo();

// Выводим ссылки на страницы
// Need to add ?page=$page to all links we want to
// maintain the current page (or store $page in $session)


?>

<?php
// Объекты создаются автоматичиски в наших функциях. Это упрощает работу.
// Наши методы, такие как find_by_id(1) работают через Метод find_by_sql() который создаёт ассоциативный массив и вызывает функцию instantiate($record) которая проверяет совпадают ли значения у ключей нашего массива со значениями атрибутов нашего класса User (функция has_attribute($attribute)), если значения присутствуют, происходит инстанцирование, функция создаёт объект и придаёт значения атрибутам. По заверщению мы получаем массив с объектами заполненными значениями.
//
//$user = User::find_by_id(1);
//echo $user->full_name();
//
//echo "<br>";
//echo "<hr>";
//
//$users = User::find_all();
//foreach($users as $user) {
//    echo "User: " . $user->username . "<br>";
//    echo "Name: " . $user->full_name() . "<br><br>";
//}
?>

<?php include_layout_template('header.php'); ?>

<?php if(isset($_GET['photo']) && !empty($_GET['photo'])): ?>

<?php 

$id = $_GET['photo'];
$photo = Photograph::find_by_id($id);
if(!$photo) {
    $session->message("Фотографии не были найдены.");
    redirect_to('index.php');
}
if(isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);
    if($author == "Admin") {
        $session->message("Ты не можешь зваться админом"); 
        redirect_to("index.php");
    }
    $new_comment = Comment::make($photo->id, $author, $body);
    if($new_comment && $new_comment->save()) {
        // comment saved
        // No message needed; seeing the comment is proof enough.
        
        // Send email
        $new_comment->try_to_send_notification();
        // Important! You could just let the page render from here.
        // But then if the page is reloaded, the form will try
        // to resubmit the comment. So redirect instead:
        redirect_to("index.php?photo={$photo->id}");
    } else {
        // Failed
        $message = "Была обнаружена ошибка при создании коментария.";
    }
} else {
    $author = "";
    $body = "";
}

$comments = $photo->comments();
    
?>
    
<?php include("view/modal_window.php"); ?>
    
<?php endif; ?> 

<?php include("view/index.php"); ?>
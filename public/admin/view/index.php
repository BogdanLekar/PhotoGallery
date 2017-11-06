<?php include_layout_template('admin_header.php'); ?>

<h2>Меню</h2>

<?php echo output_massage($message); ?>
   
<div id="content">
    <a href="logfile.php">Логи</a>
    <br>
    <a href="new_subject.php">Папки</a>
    <br>
    <a href="photo_upload.php">Загрузить фотографии</a>
    <br>
    <a href="list_photos.php">Посмотреть фотографии</a>
    <br>
    <a href="add_admin.php"> Добавить администратора</a>
</div>
    
<?php include_layout_template('admin_footer.php'); ?>
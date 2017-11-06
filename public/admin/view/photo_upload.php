<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&lt;&lt; Назад</a>
<h2>Загрузить фото</h2>

<?php echo output_massage($message); ?> 
 
<form id="deta" action="photo_upload.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" >
    <p><input type="file" name="file_upload" accept="image/x-png,image/gif,image/jpeg"></p>
    <p>Описание: <input type="text" name="caption" value="" ></p>
    <p> Папка: 
    <select name="subject" form="deta">
      <?php foreach ($subjects as $subject) : ?>
          <option value="<?php echo $subject->id; ?>"><?php echo $subject->menu_name; ?></option>
      <?php endforeach; ?>
    </select></p>
    <input type="submit" name="submit" value="Загрузить" >
</form>
        
<?php include_layout_template('admin_footer.php'); ?>
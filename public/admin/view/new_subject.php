<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&lt;&lt; Назад</a>
<h2>Добавить папку</h2>

<?php echo output_massage($message); ?>
   
<div id="content">
    <form action="new_subject.php" method="post" >
        <p>Название:
            <input type="text" name="menu_name" value="">
        </p>
        <p>Видимость:
            <input type="radio" name="visible" value="0"> Нет &nbsp;
            <input type="radio" name="visible" value="1" checked> Да
        </p>
        <p class="submit_batton">
            <input type="submit" value="Добавить папку" name="submit">
        </p>
    </form>
    <div id="subjects">
        <table border="1px">
            <th>Имя</th>
            <th>Видимость</th>
            <th>Добавить</th>
            <th>Удалить</th>
            
        <?php foreach($subjects_object as $subject) : ?>
           <tr>
                <td><?php echo $subject->menu_name; ?></td>
                <td><?php echo $subject->visible; ?></td>
                <td>
                   <a href="add_photo_in_folder.php?id=<?php echo $subject->id; ?>">Добавить фото</a>
                </td>
                <td>
                   <a href="delete_folder.php?id=<?php echo $subject->id; ?>">Удалить папку</a>
                </td>
           </tr>
           
         <?php endforeach; ?>
         
        </table> 
    </div>
</div>
    
<?php include_layout_template('admin_footer.php'); ?>
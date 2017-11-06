<?php include_layout_template('admin_header.php'); ?>
   
<div id="content">
    <a href="index.php">&lt;&lt; Назад</a>
    <br>
    <h2>Фотографии</h2>
       <a href="photo_upload.php">Загрузить фотографии</a>
       <br>
       <br>
       
       <?php echo output_massage($message); ?>
       
       <table class="bordered">
            <tr>
               <th>Фото</th>
               <th>Имя</th>
               <th>Описание</th>
               <th>Коментарий</th>
               <th>Размер фото</th>
               <th>Формат</th>
               <th>&nbsp;</th>
            </tr>
            
            <?php foreach($photos as $photo): ?>
            
            <?php
                
            $comment = Comment::find_comments_on($photo->id);
            $count_comment = $database->affected_rows(); //- Первый способ посчитать кол-во комментариев.
                //$count = count($photo->comments()); //- второй способ
           
            ?>
            
            <tr>
                <td><img src="../<?php echo $photo->image_path(); ?>" width="100"></td>
                <td><?php echo $photo->filename; ?></td>
                <td><?php echo $photo->caption; ?></td>
                <td>
                <?php 
                    $href_comment = Comment::a_count_comment($count_comment, $photo->id);
                    echo $href_comment;
                ?>
                </td>
                <td><?php echo $photo->size_as_text(); ?></td>
                <td><?php echo $photo->type; ?></td>
                <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Удалить</a></td>
            </tr>
            
            <?php endforeach; ?>
            
        </table>
</div>
<div id="pagination">
    
    <?php
    if($pagination->total_pages() > 1) {
        if($pagination->has_previous_page()){
            echo "<a href=\"list_photos.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo; Предыдущая </a>";
        } 
        for($i=1; $i <= $pagination->total_pages(); $i++) {
            if($i == $page) {
                echo " <span class=\"selected\">{$i}</span> ";
            } else {
                echo " <a href=\"list_photos.php?page={$i}\">{$i}</a> ";
            }
        }
        if($pagination->has_next_page()) {
            echo "<a href=\"list_photos.php?page=";
            echo $pagination->next_page();
            echo "\"> Слудущая &raquo;</a>";
        }
    }
    ?>
    
</div>
    
<?php include_layout_template('admin_footer.php'); ?>
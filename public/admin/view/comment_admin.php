<?php include_layout_template('admin_header.php'); ?>

<a href="list_photos.php?page=<?php echo $_SESSION['page']; ?>">&lt;&lt; Назад</a>
<h2>Комментарии</h2>

<?php echo output_massage($message); ?>
   
<div id="content" class="comment_content">
    <div id="comment_photo">
        <p><?php echo $photo->caption; ?></p>
        <img src="../<?php echo $photo->image_path(); ?>">
    </div>
    <div id="comments">
       
        <?php foreach($comments as $comment): ?>
        
        <div class="comment" style="margin-bottom: 2em;">
            <div class="author"><b>
                <?php echo htmlentities($comment->author); ?></b> прокоментировал:
            </div>
            <div class="body">
               
                <?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
                
            </div>
            <div class="meta-info" style="font-size: 0.8em;">
            
            <?php $date = DatetimeObject::datetime_to_russia_text($comment->created); 
            echo $date->date_time; ?>
            
            </div>
            <a href="delete_comment.php?id=<?php echo $comment->id; ?>" onclick="return confirm('Вы уверенны?');">Удалить</a>
        </div>
        
        <?php endforeach; ?>
        
        <?php if(empty($comments)) { echo "Коментариев нет"; } ?>
        
        <div id="comment-form" class="admin_comment">
            <h3>Добавить коментарий</h3>
            <form action="comment_admin.php?photo_id=<?php echo $photo->id; ?>" method="post">
                <table>
                    <tr>
                        <td>Имя:</td>
                        <td><input type="text" name="author" value="<?php echo $author; ?>"></td>
                    </tr>
                    <tr>
                        <td>Коментарий:</td>
                        <td><textarea name="body" cols="30" rows="8"></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" value="Прокоментировать"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
    
<?php include_layout_template('admin_footer.php'); ?>
<a href="index.php?page=<?php echo $pagination->current_page; ?>">
<div id="modalContainer">
</div>
</a>
<div id="modalWindow">
    <div id="photoBlock">
        <img src="<?php echo $photo->image_path(); ?>">
    </div>
    <div id="modalContent">
        <p><?php echo $photo->caption; ?></p>
        <p><a href="<?php echo $photo->image_path(); ?>" download>Скачать файл</a></p>
        <!-- list comments -->
        <div id="comments">
           
            <?php foreach($comments as $comment): ?>
            
            <div class="comment" style="margin-bottom: 2em;">
                <div class="author"><b>
                <?php echo htmlentities($comment->author); ?></b> прокоментировал(ла):
                </div>
                <div class="body">
                    <?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
                </div>
                <div class="meta-info" style="font-size: 0.8em;">
                    
                <?php               
                $date = DatetimeObject::datetime_to_russia_text($comment->created); 
                echo $date->date_time;
                ?>
                    
                </div>
            </div>
            
            <?php endforeach; ?>
            
            <?php if(empty($comments)) { echo "Коментариев нет."; } ?>
            
        </div>
        <div id="comment-form">
            <h3>Коментарии</h3>
            
            <?php echo output_massage($message); ?>
            
            <form action="index.php?photo=<?php echo $photo->id; ?>" method="post">
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
                        <td><input type="submit" name="submit" value="Разместить"></td>
                    </tr>
                </table>
            </form>
        </div>   
    </div>     
    <div id="exit"><a href="index.php?page=<?php echo $pagination->current_page; ?>">X</a></div>  
</div>
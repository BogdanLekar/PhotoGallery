<h2>Фотографии</h2>

<?php echo $session->message(); ?>

<div id="block_photo">
   <ul>
     
      <?php foreach($photos as $photo) : ?>
         
          <li>
              <a href="index.php?photo=<?php echo urlencode($photo->id); ?>&page=<?php echo $pagination->current_page; ?>">
                  <img src="<?php echo $photo->image_path(); ?>">
              </a>
          </li>
          
      <?php endforeach; ?>
      
   </ul>
    
</div>
<div id="pagination">
   
    <?php
    if($pagination->total_pages() > 1) {
        if($pagination->has_previous_page()) {
            echo " <a href=\"index.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo; Предыдущая</a> ";
        }
        for($i=1; $i <= $pagination->total_pages(); $i++) {
            if($i == $page) {
                echo " <span class=\"selected\">{$i}</span> ";
            } else {
                echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
            }
        }
        if($pagination->has_next_page()) {
            echo " <a href=\"index.php?page=";
            echo $pagination->next_page();
            echo "\">Слудущая &raquo;</a> ";
        }        
    }
    ?>
    
</div>

<?php include_layout_template('footer.php'); ?>
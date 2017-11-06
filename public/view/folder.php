<?php include_layout_template('header.php'); ?>
    
<h2>Категории</h2>
<div id="folder_page">

<?php echo $session->message(); ?>

<div id="folder_block">

<?php foreach($subjects as $subject) : ?>

<a class="folder_element" href="folders.php?subject_id=<?php echo $subject->id; ?>"> 
<div id="folder"><?php echo $subject->menu_name; ?></div>
</a>

<?php endforeach; ?>

</div>

<?php if(isset($photos) && !empty($photos)): ?>

<div id="photo_categori">
    <?php foreach($photos as $photo) : ?>
        <img src="<?php echo $photo->image_path(); ?>">
    <?php endforeach; ?>
</div>
<div id="pagination">
   
<?php
    
//Pagination Photo
if($pagination->total_pages() > 1) {
    if($pagination->has_previous_page()) {
        echo " <a href=\"folders.php?page=";
        echo $pagination->previous_page();
        echo "&subject_id=";
        echo $subject->id;
        echo "\">&laquo; Previous</a> ";
    }
    for($i=1; $i <= $pagination->total_pages(); $i++) {
        if($i == $page) {
            echo " <span class=\"selected\">{$i}</span> ";
        } else {
            echo " <a href=\"folders.php?page={$i}&subject_id={$subject->id}\">{$i}</a> ";
        }
    }
    if($pagination->has_next_page()) {
        echo " <a href=\"folders.php?page=";
        echo $pagination->next_page();
        echo "&subject_id=";
        echo $subject->id;
        echo "\">Next &raquo;</a> ";
    }        
}
?>
    
</div>

<?php else : ?>

<p>Эта папка пуста</p>

<?php endif; ?>

</div>

<?php include_layout_template('footer.php'); ?>
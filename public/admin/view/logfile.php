<?php include_layout_template('admin_header.php'); ?>
  
<a href="index.php">&lt;&lt; Назад</a>
<h2>Логи</h2>

<?php $logger->show_logs_in_html(); ?>

<a href="logfile.php?clear=true">Удалить логи</a>

<?php include_layout_template('admin_footer.php'); ?>
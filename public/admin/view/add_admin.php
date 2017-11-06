<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&lt;&lt; Назад</a>
<h2>Добавить Админа</h2>

<?php echo output_massage($message); ?>
   
<div id="content">
    <form action="add_admin.php" method="post" >
        <input type="text" name="name" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <br><br>
        <input type="text" name="fname" placeholder="Имя">
        <input type="text" name="lname" placeholder="Фамилия">
        <br><br>
        <input type="submit" name="submit" value="Добавить">
    </form> 
    <div id="users">
        <h2>Админы</h2>
        <table border="1px">
        <th>Логин</th>
        <th>Имя</th>
        <th>Пароль</th>
        <th>Удалить</th>
        <?php foreach($users as $user): ?>
           <tr>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $user->first_name; ?></td>
                <td><?php echo $user->last_name; ?></td>
                <td><?php echo "<a href=delete_user.php?id={$user->id}>Удалить</a>"?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>
    
<?php include_layout_template('admin_footer.php'); ?>
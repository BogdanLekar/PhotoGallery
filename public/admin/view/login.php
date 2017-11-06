<?php include_layout_template('admin_header.php'); ?>
   
<h2>Авторизация</h2>
<?php echo output_massage($message); ?>
<form action="login.php" method="post" >
    <table>
        <tr>
            <td>Логин:</td>
            <td>
                <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>">
            </td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td>
                <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>">
            </td>
        </tr>  
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Вход">
            </td>
        </tr> 
    </table>
</form>
    
<?php include_layout_template('admin_footer.php'); ?>
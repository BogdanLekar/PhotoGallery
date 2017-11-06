<html>
    <head>
        <meta charset="utf-8">
        <title>Photo Gallery: Admin</title>
        <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <header id="header">
            <h1>Photo Gallery: Admin</h1>
            
            <?php if(isset($_SESSION["user_id"])): ?>
            
            <div id="out"><a href="out.php">Выйти</a></div>
            
            <?php endif; ?>
            
        </header>
        <main id="main">
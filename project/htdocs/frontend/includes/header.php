<html>
    <head>
        <title>My Site</title>

        <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/base.css"); ?>">
        <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/fonts.css"); ?>">

        <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/header.css"); ?>">
        <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/footer.css"); ?>">
        <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/infomessages.css"); ?>">

        <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/project.css"); ?>">
    </head>
    <body>
        <?php
            Template::includeTemplate("infomessages.php");
        ?>

        <main>
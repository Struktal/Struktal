<html>
    <head>
        <title><?php echo Template::getWebsiteTitle(); ?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php if (Config::$PROJECT_SETTINGS["PRODUCTION"]): ?>
            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/style.min.css"); ?>">
        <?php else: ?>
            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/base.css"); ?>">
            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/fonts.css"); ?>">

            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/header.css"); ?>">
            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/footer.css"); ?>">
            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/infomessages.css"); ?>">

            <link rel="stylesheet" href="<?php echo Router::staticFilePath("css/project.css"); ?>">
        <?php endif; ?>

        <script src="<?php echo Router::staticFilePath("js/lib/jquery.min.js"); ?>"></script>

        <?php if (Config::$PROJECT_SETTINGS["PRODUCTION"]): ?>
            <script src="<?php echo Router::staticFilePath("js/script.min.js"); ?>"></script>
        <?php else: ?>
            <script src="<?php echo Router::staticFilePath("js/sidebar.js"); ?>"></script>
            <script src="<?php echo Router::staticFilePath("js/infomessage.js"); ?>"></script>
        <?php endif; ?>
    </head>
    <body>
        <nav>
            <div class="header-logo">
                <a href="#">
                    <img src="<?php echo Router::staticFilePath("img/logo.svg"); ?>" alt="Logo">
                    <span>
                        <?php echo Config::$PROJECT_SETTINGS["PROJECT_NAME"]; ?>
                    </span>
                </a>
            </div>

            <ul class="header-navigator header-navigator-default">
                <?php foreach (Config::$MENU_SETTINGS["MENU_SIDEBAR"] as $displayName => $settings): ?>
                    <li>
                        <a href="<?php echo $settings["route"]; ?>">
                            <span><?php echo $displayName; ?></span>
                        </a>
                    </li>
                    <hr>
                <?php endforeach; ?>
            </ul>

            <div class="header-burger">
                <div class="l1"></div>
                <div class="l2"></div>
                <div class="l3"></div>
            </div>

            <div class="header-dark-background header-dark-background-default"></div>

            <script>
                let sidebar = new Sidebar(".header-navigator", ".header-burger", ".header-dark-background");
            </script>
        </nav>

        <main>
            <?php
                Template::include("infomessages.php");
            ?>
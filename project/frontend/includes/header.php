<?php
use jensostertag\Templify\Templify;
?>

    <!DOCTYPE html>
    <html>
    <head>
        <?php // Encoding ?>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php // Browser Tab ?>
        <title><?php
            output(
                (
                Templify::getConfig("WEBSITE_TITLE") !== null ?
                    Templify::getConfig("WEBSITE_TITLE") . " - "
                    :
                    ""
                ) . Config::$PROJECT_SETTINGS["WEBSITE_TITLE"]
            );
            ?></title>
        <link rel="icon" href="<?php output(Config::$PROJECT_SETTINGS["PROJECT_FAVICON"]); ?>" type="image/x-icon">

        <?php // Basic SEO ?>
        <meta name="description" content="<?php output(SEO::getDescription()); ?>">
        <meta name="keywords" content="<?php output(implode(", ", Config::$SEO_SETTINGS["SEO_KEYWORDS"])); ?>">
        <meta name="author" content="<?php output(Config::$PROJECT_SETTINGS["PROJECT_AUTHOR"]); ?>">

        <?php // OpenGraph SEO ?>
        <meta property="og:title" content="<?php
        output(
            (
            Templify::getConfig("WEBSITE_TITLE") !== null ?
                Templify::getConfig("WEBSITE_TITLE") . " - "
                :
                ""
            ) . Config::$PROJECT_SETTINGS["WEBSITE_TITLE"]
        );
        ?>">
        <meta property="og:description" content="<?php output(SEO::getDescription()); ?>">
        <meta property="og:image" content="<?php output(Config::$SEO_SETTINGS["SEO_IMAGE_PREVIEW"]); ?>">
        <meta property="og:url" content="<?php output(Router::getCalledURL()); ?>">
        <?php if (Config::$SEO_SETTINGS["SEO_OPENGRAPH"]["OPENGRAPH_SITE_NAME"] !== null): ?>
            <meta property="og:site_name" content="<?php output(Config::$SEO_SETTINGS["SEO_OPENGRAPH"]["OPENGRAPH_SITE_NAME"]); ?>">
        <?php endif; ?>
        <meta property="og:type" content="website">

        <?php // Twitter SEO ?>
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php
        output(
            (
            Templify::getConfig("WEBSITE_TITLE") !== null ?
                Templify::getConfig("WEBSITE_TITLE") . " - "
                :
                ""
            ) . Config::$PROJECT_SETTINGS["WEBSITE_TITLE"]
        );
        ?>">
        <meta name="twitter:description" content="<?php output(SEO::getDescription()); ?>">
        <meta name="twitter:image" content="<?php output(Config::$SEO_SETTINGS["SEO_IMAGE_PREVIEW"]); ?>">
        <meta name="twitter:url" content="<?php output(Router::getCalledURL()); ?>">
        <?php if (Config::$SEO_SETTINGS["SEO_TWITTER"]["TWITTER_SITE"] !== null): ?>
            <meta name="twitter:site" content="<?php output(Config::$SEO_SETTINGS["SEO_TWITTER"]["TWITTER_SITE"]); ?>">
        <?php endif; ?>
        <?php if (Config::$SEO_SETTINGS["SEO_TWITTER"]["TWITTER_CREATOR"] !== null): ?>
            <meta name="twitter:creator" content="<?php output(Config::$SEO_SETTINGS["SEO_TWITTER"]["TWITTER_CREATOR"]); ?>">
        <?php endif; ?>

        <?php // Indexing ?>
        <meta name="robots" content="<?php output(implode(", ", SEO::getRobots())); ?>">
        <meta name="revisit-after" content="<?php output(Config::$SEO_SETTINGS["SEO_REVISIT"]); ?>">

        <?php // CSS ?>
        <link rel="stylesheet" href="<?php output(Router::staticFilePath("css/style.css")); ?>">

        <?php // JavaScript ?>
        <script src="<?php output(Router::staticFilePath("js/lib/jquery.min.js")); ?>"></script>
        <script src="<?php output(Router::staticFilePath("js/infomessage.js")); ?>"></script>
    </head>
    <body class="bg-background overflow-x-hidden">
        <header class="flex justify-between items-center min-h-24 px-content-padding-sm md:px-content-padding-md lg:px-content-padding-lg bg-background-header text-font-header">
            <?php // Logo ?>
            <div class="whitespace-nowrap">
                <a href="<?php output(Router::generate(Config::$PROJECT_SETTINGS["PROJECT_URL"])); ?>"
                   class="flex justify-start items-center uppercase"
                >
                    <img src="<?php output(Router::staticFilePath("img/logo.svg")); ?>"
                         alt="Logo"
                         class="h-16 w-auto rounded"
                    >
                    <span class="hidden sm:block ml-2 font-bold">
                        <?php output(Config::$PROJECT_SETTINGS["PROJECT_NAME"]); ?>
                    </span>
                </a>
            </div>

            <?php // Sidebar open button ?>
            <button id="header-sidebar-open" class="btn">
                <svg class="w-6 h-6 stroke-current"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M3 12h18M3 6h18M3 18h18"></path>
                </svg>
            </button>

            <?php // Sidebar popup ?>
            <div class="header-sidebar-popup absolute top-0 right-0 z-200 w-header-sidebar-width-sm sm:w-header-sidebar-width-md md:w-header-sidebar-width-lg h-full p-header-sidebar-padding bg-background-header border-l border-gray translate-x-full transition-all">
                <div class="flex">
                    <?php // Sidebar close button ?>
                    <button class="ml-auto mr-0" id="header-sidebar-close">
                        <svg class="w-6 h-6 stroke-current"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M6 18L18 6M6 6l12 12">
                        </svg>
                    </button>
                </div>

                <?php // Sidebar navigation list ?>
                <nav>
                    <ul>
                        <?php foreach (Config::$MENU_SETTINGS["MENU_SIDEBAR"] as $displayName => $settings): ?>
                            <li class="my-2 text-right">
                                <a href="<?php output($settings["route"]); ?>">
                                <span class="hover:border-b-4 transition-all">
                                    <?php output($displayName); ?>
                                </span>
                                </a>
                            </li>
                            <hr class="w-full h-px">
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>

            <?php // Sidebar background layer ?>
            <div class="header-sidebar-background hidden absolute left-0 top-0 w-full h-full z-100 backdrop-blur"></div>

            <script type="module">
                import Sidebar from "<?php output(Router::staticFilePath("js/Sidebar.js")); ?>";
                Sidebar.init();
            </script>
        </header>

        <main class="px-content-padding-sm mt-4 md:px-content-padding-md lg:px-content-padding-lg min-h-[90vh]">
            <?php
            Templify::include("infomessages.php");
            ?>

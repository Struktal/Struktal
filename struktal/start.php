<?php

// Autoload Composer libraries
require_once(__APP_DIR__ . "/vendor/autoload.php");

// ClassLoader
require_once(__APP_DIR__ . "/struktal/src/ClassLoader.class.php");
$classLoader = ClassLoader::getInstance();

// Setup utility Composer libraries
use struktal\Config\StruktalConfig;
StruktalConfig::setConfigFilePath(__APP_DIR__ . "/config/config.json");
const Config = new StruktalConfig();

// Load Logger
$classLoader->loadClass(__APP_DIR__ . "/struktal/src/Logger.class.php");

// Load Comm
$classLoader->loadClass(__APP_DIR__ . "/struktal/src/Comm.class.php");

// Load enums
$classLoader->loadEnums(__APP_DIR__ . "/struktal/src/enum/");

// Load libraries
$classLoader->loadClasses(__APP_DIR__ . "/struktal/src/lib/");

// Load project files
$classLoader->loadClasses(__APP_DIR__ . "/src/lib/");
$classLoader->loadEnums(__APP_DIR__ . "/src/lib/");

unset($classLoader);

// Setup Composer libraries
use eftec\bladeone\BladeOne;
const Blade = new BladeOne(__APP_DIR__ . "/src/templates", __APP_DIR__ . "/template-cache", BladeOne::MODE_DEBUG);

use struktal\Router\Router;
const Router = new Router();
Router->setPagesDirectory(__APP_DIR__ . "/src/pages/");
Router->setAppUrl(Config->getappUrl());
Router->setAppBaseUri(Config->getBaseUri());
Router->setStaticDirectoryUri("static/");

use struktal\ORM\Database\Database;
if(Config->databaseEnabled()) {
    Database::connect(
        Config->getDatabaseHost(),
        Config->getDatabaseName(),
        Config->getDatabaseUsername(),
        Config->getDatabasePassword()
    );
}

use struktal\Auth\Auth;
const Auth = new Auth();
Auth->setUserObjectName(User::class);

use struktal\validation\ValidationBuilder;
const Validation = new ValidationBuilder();

use struktal\ComposerReader\ComposerReader;
ComposerReader::setProjectDirectory(__APP_DIR__);
const ComposerReader = new ComposerReader();

// Override BladeOne's include directive to use components with isolated variables
Blade->directive("include", function($expression) {
    $code = Blade->phpTag . " Blade->startComponent($expression); ?>";
    $code .= Blade->phpTag . ' echo Blade->renderComponent(); ?>';
    return $code;
});

// Setup logger
$sendEmailHandler = function(string $message) {
    if(empty(Config->getLogRecipients())) {
        return;
    }

    $mail = new Mail();
    $mail->setSubject("[" . Config->getAppName() . "] Error report")
        ->setTextBody($message);
    foreach(Config->getLogRecipients() as $recipient) {
        $mail->addRecipient($recipient);
    }
    $mail->send();
};
Logger::addCustomLogHandler(Logger::$LOG_ERROR, $sendEmailHandler);
Logger::addCustomLogHandler(Logger::$LOG_FATAL, $sendEmailHandler);
unset($sendEmailHandler);

// Initialize routes
require_once(__APP_DIR__ . "/src/config/app-routes.php");

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $message = "Error " . $errno . ": ";
    $message .= "\"" . $errstr . "\"";
    $message .= " in " . $errfile . " on line " . $errline;
    try {
        Logger::getLogger("PHP")->error($message);
    } catch(Error|Exception $e) {
        // If the logger fails, log to the default PHP error log
        error_log($message);
    }

    if(Config->isProduction()) {
        // Redirect to error page in production
        Router->redirect(Router->generate("500"));
    } else {
        // Show stack trace screen in development
        echo Blade->run("components.shells.deverror", [
            "exceptionName" => "Error " . $errno,
            "exceptionMessage" => $errstr,
            "trace" => [
                [
                    "file" => $errfile,
                    "line" => $errline
                ]
            ]
        ]);
    }
});

set_exception_handler(function($exception) {
    $message = "Uncaught " . get_class($exception) . ": ";
    $message .= "\"" . $exception->getMessage() . "\"";
    $message .= " in " . $exception->getFile() . " on line " . $exception->getLine();
    $message .= PHP_EOL . $exception->getTraceAsString();

    try {
        Logger::getLogger("PHP")->fatal($message);
    } catch(Error|Exception $e) {
        error_log($message);
    }

    if(Config->isProduction()) {
        // Redirect to error page in production
        Router->redirect(Router->generate("500"));
    } else {
        // Show stack trace screen in development
        $trace = $exception->getTrace();
        echo Blade->run("components.shells.deverror", [
            "exceptionName" => get_class($exception),
            "exceptionMessage" => $exception->getMessage(),
            "trace" => [
                [
                    "file" => $exception->getFile(),
                    "line" => $exception->getLine()
                ],
                ...$trace
            ]
        ]);
    }
});

// Setup timezone
date_default_timezone_set("UTC");

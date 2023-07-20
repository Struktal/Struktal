<?php

const PROJECT_NAME = "PHP-Framework";
const SUCCESS_MAIL = [];

header("Content-Type: text/plain");

function getTimestamp(): string {
    $dateTime = new DateTime();
    return $dateTime->format("Y/m/d  H-i-s");
}

echo "##################################################" . PHP_EOL;
echo "#                   DEPLOYMENT                   #" . PHP_EOL;
echo "#              " . getTimestamp() . "              #" . PHP_EOL;
echo "##################################################" . PHP_EOL;
echo PHP_EOL;

// Check allowed IP Addresses
echo "Checking access permission" . PHP_EOL;

$allowedIps = [
    "207.97.227.", "50.57.128.", "108.171.174.", "50.57.231.", "204.232.175.", "192.30.252." // GitHub IPs
];

$allowed = false;
$ip = $_SERVER["REMOTE_ADDR"];

foreach($allowedIps as $allowedIp) {
    if(str_starts_with($ip, $allowedIp)) {
        $allowed = true;
        break;
    }
}

if(!$allowed) {
    echo "You are not allowed to access this file" . PHP_EOL;
    exit;
}

echo "Access granted" . PHP_EOL;
echo PHP_EOL;

// Commands
$commands = [
    "whoami",
    "git pull"
];

if(isset($_GET["install-composer"])) {
    $commands[] = "composer install";
}

// Run Commands with exec
foreach($commands as $command) {
    echo "Running command: " . $command . PHP_EOL;
    $output = [];
    $resultCode = 0;
    exec($command, $output, $resultCode);
    foreach($output as $line) {
        echo $line . PHP_EOL;
    }
    echo "Finished with result code " . $resultCode . PHP_EOL;
    echo PHP_EOL;
}

// Send Mails
foreach(SUCCESS_MAIL as $mail) {
    $subject = "Deployment of " . PROJECT_NAME;
    $body = "The deployment of " . PROJECT_NAME . " finished successfully at " . getTimestamp();
    mail($mail, $subject, $body);
}

echo "Deployment finished at " . getTimestamp();

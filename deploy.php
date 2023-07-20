<?php

const PROJECT_NAME = "PHP-Framework";
const SUCCESS_MAIL = [];

header("Content-Type: text/plain");

function getTimestamp(): string {
    $dateTime = new DateTime();
    return $dateTime->format("Y/m/d  H-i-s");
}

function ipInRange($ipAddress, $addressRange): bool {
    $subnet = explode("/", $addressRange)[0];
    $mask = intval(explode("/", $addressRange)[1]);
    $isIpV6 = str_contains($ipAddress, ":");

    if($isIpV6 !== str_contains($subnet, ":")) {
        return false;
    }

    if($isIpV6) {
        $ipAddress = inet_pton($ipAddress);
        $subnet = inet_pton($subnet);

        $maskBinary = str_repeat("f", $mask / 4);
        switch($mask % 4) {
            case 1:
                $maskBinary .= "8";
                break;
            case 2:
                $maskBinary .= "c";
                break;
            case 3:
                $maskBinary .= "e";
                break;
        }

        $maskBinary = str_pad($maskBinary, 32, "0");
        $maskBinary = pack("H*", $maskBinary);
        return ($ipAddress & $maskBinary) === $subnet;
    } else {
        if($mask <= 0) {
            return false;
        }

        $ipAddressBinary = sprintf("%032b", ip2long($ipAddress));
        $subnetBinary = sprintf("%032b", ip2long($subnet));
        return (substr_compare($ipAddressBinary, $subnetBinary, 0, $mask) === 0);
    }
}

echo "##################################################" . PHP_EOL;
echo "#                   DEPLOYMENT                   #" . PHP_EOL;
echo "#              " . getTimestamp() . "              #" . PHP_EOL;
echo "##################################################" . PHP_EOL;
echo PHP_EOL;

// Check allowed IP Addresses
echo "Checking access permission" . PHP_EOL;

// Retrieve allowed IPs from the GitHub API
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.github.com/meta");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, "PHP Deployment Script");
$response = curl_exec($curl);
curl_close($curl);

if($response === false) {
    http_response_code(500);
    echo "Failed to retrieve allowed IPs from GitHub API" . PHP_EOL;
    exit;
}

$jsonResponse = json_decode($response, true);
$allowedIps = $jsonResponse["actions"];

$allowed = false;
$ip = $_SERVER["REMOTE_ADDR"];

foreach($allowedIps as $allowedIp) {
    if(ipInRange($ip, $allowedIp)) {
        $allowed = true;
        break;
    }
}

if(!$allowed) {
    http_response_code(403);
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

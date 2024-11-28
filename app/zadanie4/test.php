<?php
session_start();
if (! isset($_SESSION["zscan-logged-in"])) {
    header("Location: /zadanie4/auth/login-form.php");
    exit();
}

$host = 'fb.com';
$port = '80';
{
    $fp = @fsockopen($host, $port, $errno, $errstr, 30);
    echo 'Host '.$host.':'.$port.' jest: ';
    if ($fp) { echo 'OK'; } else { echo 'Awaria'; }
    if (!$fp) { echo "$errstr ($errno)"; }
}


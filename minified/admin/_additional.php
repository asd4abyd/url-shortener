<?php


require_once('../_config.php');

session_start();

if(!isset($_SESSION['key'], $_SESSION['exp']) or $_SESSION['exp']<time()) {
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately

    header('Location: sign.php');
    exit();
}
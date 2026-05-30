<?php
session_start();
require_once '../config.php';
require_once '../core/Auth.php';
require_once '../core/Database.php';

if (!Auth::isAdmin()) {
    header('Location: login.php');
    exit;
}

Auth::logout();
header('Location: login.php');
?>

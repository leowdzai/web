<?php

require 'config.php';
require 'functions.php';
require 'auth.php';
require 'helpers.php';

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Headers
header('Content-Type: text/html; charset=utf-8');

?>

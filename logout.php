<?php


session_start();
session_destroy();
header('location:http://localhost/php_basic/02-ex/login.php');
exit;
?>
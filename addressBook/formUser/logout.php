<?php
session_start();
require '../config/error_reporting.php';
require '../header/headerTitleLocalhost.html';
unset($_SESSION['user']);
require '../header/headerFormUser.php';
?>
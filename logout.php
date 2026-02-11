<?php
require_once 'config/db.php';
require_once 'config/functions.php';

session_destroy();
session_start();
setFlash('success', 'Umefanya logout!');
header('Location: login.php');
exit();
?>

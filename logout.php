<?php
require_once 'config.php';
require_once 'dbFunctions.php';

session_start();

// logout.php
 
// Выход
unset($_SESSION['user']);

header("Location: /");
exit();
?>
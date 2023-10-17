<?php
require_once 'config.php';
require_once 'dbFunctions.php';
// comments.php

session_start();

// Проверка, является ли пользователь авторизованным
if (!isset($_SESSION['user'])) {
    die("Ошибка: Недостаточно прав для добавления комментариев.");
}

// Проверка наличия параметров
if (!isset($_POST['image']) || !isset($_POST['author']) || !isset($_POST['text'])) {
    die("Ошибка: Не указаны все необходимые параметры.");
}

$image = $_POST['image'];
$author = $_POST['author'];
$text = $_POST['text'];

// Сохранение комментария в базе данных
saveComment($image, $author, $text);

// Перенаправление на главную страницу
header("Location: index.php");
exit();
?>

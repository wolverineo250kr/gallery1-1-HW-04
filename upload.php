<?php
require_once 'config.php';
require_once 'dbFunctions.php';
session_start();
// upload.php


// Проверка, является ли пользователь авторизованным
if (!isset($_SESSION['user'])) {
    die("Ошибка: Недостаточно прав для загрузки файла.");
}

// Проверка наличия файла
if (!isset($_FILES['image']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
    die("Ошибка: Файл не был загружен.");
}

// Проверка размера файла
if ($_FILES['image']['size'] > MAX_FILE_SIZE) {
    die("Ошибка: Превышен максимально допустимый размер файла.");
}

// Проверка типа файла
if (!in_array($_FILES['image']['type'], ALLOWED_FILE_TYPES)) {
    die("Ошибка: Недопустимый тип файла.");
}

// Генерация уникального имени файла
$filename = base64_encode($_SESSION['user']) . "____" . uniqid() . '_' . $_FILES['image']['name'];

// Сохранение файла на сервере
$destination = UPLOAD_PATH . $filename;
if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    die("Ошибка: Не удалось сохранить файл на сервере.");
}

// Перенаправление на главную страницу
header("Location: index.php");
exit();
?>

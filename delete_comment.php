<?php
require_once 'config.php';
require_once 'dbFunctions.php';
// delete.php

session_start();

// Проверка, является ли пользователь авторизованным
if (!isset($_SESSION['user'])) {
    die("Ошибка: Недостаточно прав для удаления файла и комментариев.");
}

if (!isset($_GET['comment-id'])) {
    // Параметр не передан
    echo "Параметр не найден";
}

// Подключение к базе данных
$pdo = connectDbPdo();

// Подготовка и выполнение SQL-запроса для удаления записи из базы данных
$commentId = $_GET['comment-id'];
$author = $_SESSION['user'];

$query = $pdo->prepare("DELETE FROM comments WHERE id = :commentId AND author = :author");
$query->bindParam(':commentId', $commentId);
$query->bindParam(':author', $author);

try {
    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            // Запись была успешно удалена
            header("Location: index.php");
            exit();
        } else {
            // Запись не была найдена
            echo "Запись не была найдена";
            die;
        }
    } else {
        echo "Не вышло!";
        die;
    }
} catch (PDOException $e) {
    die("Ошибка выполнения SQL-запроса: " . $e->getMessage());
}
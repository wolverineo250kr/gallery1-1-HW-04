<?php

require_once 'config.php';
require_once 'dbFunctions.php';
// delete.php

session_start();

// Проверка, является ли пользователь авторизованным
if (!isset($_SESSION['user'])) {
    die("Ошибка: Недостаточно прав для удаления файла и комментариев.");
}

$loginOwner = $_SESSION['user'];

if (!isset($_POST['image'])) {
    die("Ошибка: отсувует имя файла.");
}

$imgName = $_POST['image'];
$imgNameExplode = explode('____', $imgName);

if (!isset($imgNameExplode[0])) {
    die("Ошибка: плохое имя файла.");
}

$str = $imgNameExplode[0];
$newStr = str_replace(UPLOAD_PATH, "", $str);
$loginOwner = base64_decode($newStr);

if (!isset($loginOwner)) {
    die("Ошибка: плохое имя файла. Часть вторая.");
}

if ($loginOwner != $_SESSION['user']) {
    die("Ошибка: Недостаточно прав для удаления файла и комментариев. Часть вторая.");
}

// Подключение к базе данных
$pdo = connectDbPdo();

// Подготовка и выполнение SQL-запроса для удаления записей из базы данных

$query = $pdo->prepare("DELETE FROM comments WHERE image = :imgPath");
$query->bindParam(':imgPath', $imgName);

try {
    if ($query->execute()) {
        // Запись была успешно удалена
        if (file_exists($imgName)) {
            unlink($imgName);
        }

        header("Location: index.php");
        exit();
    } else {
        echo "Не вышло!";
        die;
    }
} catch (PDOException $e) {
    die("Ошибка выполнения SQL-запроса: " . $e->getMessage());
}

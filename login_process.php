<?php
require_once 'config.php';
require_once 'dbFunctions.php';
session_start();

// Подключение к базе данных
$pdo = connectDbPdo();

// Получение данных из формы
$login = $_POST['login'];
$password = $_POST['password'];

// Подготовка и выполнение SQL-запроса для получения записи пользователя из базы данных
$stmt = $pdo->prepare("SELECT * FROM gallery.users WHERE login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch();

// Проверка наличия пользователя и проверка пароля
if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user'] = $user['login'];

    header("Location: index.php");
    exit();
} else {
    echo "Неверный логин или пароль.";
}
?>
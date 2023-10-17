<?php
require_once 'config.php';
require_once 'dbFunctions.php';

// Подключение к базе данных
$pdo = connectDbPdo();

// Получение данных из формы
$login = $_POST['login'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];

// Проверка на заполнение всех необходимых полей
if (empty($login) || empty($password)) {
    die("Пожалуйста, заполните все необходимые поля.");
}

// Проверка на уникальность логина
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ?");
$stmt->execute([$login]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    die("Логин уже занят, выберите другой логин.");
}

// Хэширование пароля
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Подготовка и выполнение SQL-запроса для добавления пользователя в базу данных
$stmt = $pdo->prepare("INSERT INTO users (login, password, name, email) VALUES (?, ?, ?, ?)");

try {
    $stmt->execute([$login, $hashedPassword, $name, $email]);
    echo "Регистрация успешна!";
} catch (PDOException $e) {
    die("Ошибка регистрации: " . $e->getMessage());
}
?>
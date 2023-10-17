<?php
require_once 'config.php';
require_once 'dbFunctions.php';
session_start();
// register.php

?>
<?php if (isset($_SESSION['user'])): ?>
    <?php
    die('Уже авторизован ' . $_SESSION['user']);
    ?>
<?php endif; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация - Галерея изображений</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Подключение стилей Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Подключение моих стилей -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Подключение фэнсибокс стилей -->
    <link rel="stylesheet" href="css/fancybox.min.css"/>

    <!-- Подключение jQuery -->
    <script src="/js/jquery-3.6.0.min.js"></script>

    <!-- Подключение скриптов Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/icons8-favicon-ios-16-16.png">

</head>
<body>
<main role="main">
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="/">Главная</a>
                    <a href="login.php">Вход</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">


                    <h1>Регистрация</h1>

                    <form action="register_process.php" method="post">
                        <label for="login">Логин:</label>
                        <input type="text" name="login" id="login" required><br>

                        <label for="password">Пароль:</label>
                        <input type="password" name="password" id="password" required><br>

                        <label for="name">Имя:</label>
                        <input type="text" name="name" id="name"><br>

                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email"><br>

                        <input type="submit" class="btn btn-info" value="Зарегистрироваться">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>

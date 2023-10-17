<?php
require_once 'config.php';
require_once 'dbFunctions.php';
session_start();
// index.php

?>
<!DOCTYPE html>
<html>
<head>
    <title>Галерея изображений</title>
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
            <h1>Галерея изображений</h1>
            <div class="row">
                <div class="col-md-4">
                    <a href="/">Главная</a>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="login.php">Войти</a>
                        <a href="register.php">Регистрация</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="logout.php">Выйти</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr/>
                </div>
            </div>
            <?php
            // Вывод галереи изображений
            $images = glob(UPLOAD_PATH . '*'); // Получение всех изображений из папки загрузки
            $imageComments = []; // Определение пустого массива для хранения комментариев
            ?>

            <?php if (isset($_SESSION['user'])): ?>
                Пользователь:  <?php echo $_SESSION['user']; ?>
            <?php else: ?>
                Пользователь не авторизован.
            <?php endif; ?>
            <hr/>
            <div class="row">
                <?php foreach ($images as $image) : ?>
                    <div class="col-md-4">
                        <a data-fancybox="gallery" href="<?php echo $image; ?>"">
                        <img src="<?php echo $image; ?>" alt="Изображение" class="img-thumbnail">
                        </a>
                        <br>
                        <br>
                        <?php $comments = getComments($image); // Получение комментариев для каждого изображения?>
                        <?php $imageComments[$image] = $comments; // Сохранение комментариев в массиве с ключом, соответствующим пути к изображению?>

                        <?php foreach ($imageComments[$image] as $comment) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $comment['author']; ?>
                                    : <?php echo $comment['text']; ?>   <?php if (isset($_SESSION['user'])) : ?><? if ($comment['author'] === $_SESSION['user']): ?>&nbsp;
                                    <a href="/delete_comment.php?comment-id=<?= $comment['id'] ?>"
                                       class="remove-comment">
                                            &#10060;</a><? endif; ?><?php endif; ?><p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <form action="comments.php" method="post">
                                <input type="hidden" name="image" value="<?php echo $image; ?>">
                                <input type="hidden" name="author" value="<?php echo $_SESSION['user']; ?>"
                                       placeholder="Ваше имя" class="form-control"><br>
                                <textarea name="text" placeholder="Ваш комментарий" class="form-control"></textarea><br>
                                <input type="submit" value="Отправить комментарий" class="btn btn-primary">
                            </form>
                        <?php endif; ?>
                        <hr>
                        <?php
                        $string = explode('/', $image);
                        $string = explode('____', $string[1]);
                        $imageOwner = base64_decode($string[0]);
                        ?>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php if ($_SESSION['user'] === $imageOwner) : ?>
                                <form action="delete.php" method="post">
                                    <input type="hidden" name="image" value="<?php echo $image; ?>">
                                    <input type="submit" value="Удалить изображение" class="btn btn-danger">
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            // Форма загрузки файла (только для авторизованных пользователей)
            if (isset($_SESSION['user'])) {
                echo '<form action="upload.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="file">Выберите файл</label>
    <input type="file" name="image" id="file" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Загрузить</button>
</form>';
            }
            ?>
        </div>
    </div>
</main>

</body>

<script src="/js/fancybox.min.js"></script>
</html>

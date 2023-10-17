<?php
// db_functions.php

// Функция для подключения к базе данных
function connectDb()
{
    $host = DB_HOST;
    $user = DB_USER;
    $password = DB_PASS;
    $database = DB_NAME;

    $conn = mysqli_connect($host, $user, $password, $database);

    if (!$conn) {
        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }

    return $conn;
}

// Функция для подключения к базе данных PDO
function connectDbPdo()
{
    // Подключение к базе данных
    $host = DB_HOST;
    $user = DB_USER;
    $password = DB_PASS;
    $database = DB_NAME;

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }

    return $pdo;
}

// Функция для получения комментариев к изображению
function getComments($image)
{
    $conn = connectDb();

    $image = mysqli_real_escape_string($conn, $image);

    $query = "SELECT * FROM comments WHERE image = '$image'";
    $result = mysqli_query($conn, $query);

    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }

    mysqli_close($conn);

    return $comments;
}

// Функция для сохранения комментария в базе данных
function saveComment($image, $author, $text)
{
    $conn = connectDb();

    $image = mysqli_real_escape_string($conn, $image);
    $author = mysqli_real_escape_string($conn, $author);
    $text = mysqli_real_escape_string($conn, $text);

    $query = "INSERT INTO comments (image, author, text) VALUES ('$image', '$author', '$text')";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);

    return $result;
}

?>

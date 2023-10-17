<?php
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // Максимальный размер файла (в данном случае 5 МБ)
define('ALLOWED_FILE_TYPES', ['image/jpeg', 'image/png', 'image/gif']); // Разрешенные типы файлов
define('UPLOAD_PATH', 'uploads/'); // Путь для сохранения загруженных изображений
define('DB_HOST', 'localhost'); // Хост базы данных
define('DB_USER', 'root'); // Имя пользователя базы данных
define('DB_PASS', 'root'); // Пароль базы данных
define('DB_NAME', 'gallery'); // Имя базы данных
<?php
$host = 'localhost'; //хост бази даних
$dbname = 'local.spu111.com'; //  назва бази даних
$user = 'root'; //  ім'я користувача бази даних
$pass = ''; //пароль бази даних

try {
    // Створення екземпляру PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    // Встановлення режиму обробки помилок для PDO в режим винятків
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Виведення повідомлення про успішне підключення
    //echo "<h3>Connected successfully</h3>";
} catch (PDOException $e) {
    // Виведення повідомлення про невдале підключення разом із текстом помилки
    echo "Connection failed: " . $e->getMessage();
}

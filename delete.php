<?php
include($_SERVER["DOCUMENT_ROOT"] . "/config/connection_database.php"); // Включення файлу для з'єднання з базою даних

if(isset($_POST['id'])) {
    $id = $_POST['id']; // Отримання ідентифікатора запису, який потрібно видалити

    // Підготовка SQL-запиту для видалення запису з таблиці "categories" за ідентифікатором
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");

    // Прив'язка параметрів
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Виконання SQL-запиту
    if($stmt->execute()) {
        header("Location: /index.php"); // Перенаправлення на головну сторінку після видалення
        exit();
    } else {
        echo "Error deleting record"; // Виведення повідомлення про помилку в разі невдалого видалення
    }
} else {
    echo "Invalid request"; // Виведення повідомлення про неправильний запит, якщо ідентифікатор не був переданий
}
?>

<?php
global $pdo; // Глобальна змінна для об'єкта PDO, яка використовується для з'єднання з базою даних
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"]; // Отримання значення з поля "name" з POST-запиту
    $description = $_POST["description"]; // Отримання значення з поля "description" з POST-запиту
    $imageTmpName = $_FILES['image']['tmp_name']; // Тимчасова назва файлу при його передачі на сервер
    $dir = "/images/"; // Директорія для збереження зображення
    $image_name = uniqid() . ".jpg"; // Унікальна назва файлу для зображення
    // Шлях для збереження файлу
    $destination = $_SERVER["DOCUMENT_ROOT"] . $dir . $image_name;
    // Переміщення завантаженого файлу в папку призначення
    move_uploaded_file($imageTmpName, $destination);
    include($_SERVER["DOCUMENT_ROOT"] . "/config/connection_database.php"); // Включення файлу для з'єднання з базою даних
    // SQL-запит для вставки даних в таблицю "categories"
    $sql = "INSERT INTO categories (name, image, description) VALUES (:name, :image, :description)";
    // Підготовка SQL-запиту
    $stmt = $pdo->prepare($sql);
    // Прив'язка параметрів
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image_name);
    $stmt->bindParam(':description', $description);

    // Виконання запиту
    $stmt->execute();
    header("Location: /"); // Перенаправлення на головну сторінку
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<?php include ($_SERVER["DOCUMENT_ROOT"] . "/_header.php");?>

<main>
    <div class="container">
        <h1 class="text-center">Додати категорію</h1>
        <form class="offset-md-3 col-md-6" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3" id="selected-image-container" style="display: none;">
                <label for="selected-image" class="form-label">Обране фото</label>
                <img id="selected-image" src="" alt="Selected Image" style="max-width: 100%">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Фото</label>
                <input type="file" class="form-control" id="image" name="image" onchange="displaySelectedImage(this)">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Опис</label>
                <textarea rows="5" class="form-control" id="description" name="description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Додати</button>
        </form>
    </div>
</main>

<script src="/js/script.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>

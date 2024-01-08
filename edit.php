<?php
// Підключення необхідних файлів та конфігурацій, включаючи з'єднання з базою даних
include ($_SERVER["DOCUMENT_ROOT"] . "/config/connection_database.php");

// Перевірка, чи відправлено POST-запит
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_GET['id']; // Отримання ідентифікатора категорії з параметру URL
    $name = $_POST["name"]; // Отримання значення з поля "name" з POST-запиту
    $description = $_POST["description"]; // Отримання значення з поля "description" з POST-запиту
    $existingImage = $_POST["existing_image"]; // Отримання імені існуючого зображення
    $imageTmpName = $_FILES['image']['tmp_name']; // Тимчасова назва файлу при його передачі на сервер
    $dir = "/images/"; // Директорія для збереження зображення
    $image_name = $existingImage; // Використання існуючої назви зображення, якщо нове не завантажено

    // Перевірка, чи було завантажено нове зображення
    if (!empty($imageTmpName)) {
        // Генерація нової унікальної назви зображення
        $image_name = uniqid() . ".jpg";
        // Встановлення шляху призначення для збереження файлу
        $destination = $_SERVER["DOCUMENT_ROOT"] . $dir . $image_name;
        // Переміщення завантаженого файлу в папку призначення
        move_uploaded_file($imageTmpName, $destination);
    }

    // Оновлення даних категорії в базі даних
    $sql = "UPDATE categories SET name = :name, image = :image, description = :description WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $categoryId);

    // Виконання запиту
    $stmt->execute();

    header("Location: /"); // Перенаправлення на сторінку списку категорій
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
    <title>Edit</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<?php include ($_SERVER["DOCUMENT_ROOT"] . "/_header.php");?>

<main>
    <div class="container">
        <h1 class="text-center">Редагувати категорію</h1>
        <?php
        include ($_SERVER["DOCUMENT_ROOT"] . "/config/connection_database.php");

        // Перевірка, чи вказаний ідентифікатор категорії в параметрі URL
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];

            // Отримання даних категорії за ідентифікатором
            $stmt = $pdo->prepare("SELECT id, name, description, image FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($category) {
                ?>
                <!-- Форма для редагування категорії -->
                <form class="offset-md-3 col-md-6" method="post" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <div class="mb-3">
                        <label for="existing-image" class="form-label">Поточне фото</label>
                        <img id="existing-image" src="/images/<?php echo $category['image']; ?>" alt="Existing Image" style="max-width: 100%">
                    </div>

                    <!-- Приховане поле для передачі імені існуючого зображення -->
                    <input type="hidden" name="existing_image" value="<?php echo $category['image']; ?>">

                    <div class="mb-3" id="selected-image-container">
                        <label for="selected-image" class="form-label">Нове фото</label>
                        <img id="selected-image" src="/images/<?php echo $category['image']; ?>" alt="Selected Image" style="max-width: 100%">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Назва</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Змінити фото</label>
                        <input type="file" class="form-control" id="image" name="image" onchange="displaySelectedImage(this)">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Опис</label>
                        <textarea rows="5" class="form-control" id="description" name="description"><?php echo $category['description']; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Зберегти</button>
                </form>
                <?php
            } else {
                echo '<div class="alert alert-danger" role="alert">Категорія не знайдена</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Не вказано ID категорії для редагування</div>';
        }
        ?>
    </div>
</main>

<script src="/js/script.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>

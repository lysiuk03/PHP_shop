<?php
// Include necessary files and configurations, including database connection
include ($_SERVER["DOCUMENT_ROOT"] . "/config/connection_database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_GET['id'];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $existingImage = $_POST["existing_image"];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $dir = "/images/";
    $image_name = $existingImage; // Use existing image name if no new image is uploaded

    // Check if a new image is uploaded
    if (!empty($imageTmpName)) {
        // Generate a new unique image name
        $image_name = uniqid() . ".jpg";
        // Set the destination path
        $destination = $_SERVER["DOCUMENT_ROOT"] . $dir . $image_name;
        // Move the uploaded file to the destination
        move_uploaded_file($imageTmpName, $destination);
    }

    // Update the category data in the database
    $sql = "UPDATE categories SET name = :name, image = :image, description = :description WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $categoryId);

    // Execute the statement
    $stmt->execute();

    header("Location: /"); // Redirect to the category list page
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

        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];

            $stmt = $pdo->prepare("SELECT id, name, description, image FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($category) {
                ?>
                <form class="offset-md-3 col-md-6" method="post" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <div class="mb-3">
                        <label for="existing-image" class="form-label">Поточне фото</label>
                        <img id="existing-image" src="/images/<?php echo $category['image']; ?>" alt="Existing Image" style="max-width: 100%">
                    </div>

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

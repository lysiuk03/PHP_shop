<?php
include($_SERVER["DOCUMENT_ROOT"] . "/config/connection_database.php");

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if($stmt->execute()) {
        header("Location: /index.php");
        exit();
    } else {
        echo "Error deleting record";
    }
} else {
    echo "Invalid request";
}
?>

<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'editor') {
    header("Location: index.php");
    exit;
}

// Database connection
$servername = "CS3-DEV.ICT.RU.AC.ZA";
$username = "TheOGs";
$password = "M7fiB7C6";
$dbname = "theogs";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $ingredients = htmlspecialchars($_POST['ingredients']);
    $instructions = htmlspecialchars($_POST['instructions']);
    $uploadDir = 'img/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    // Check if the file is an image
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $newFileName = uniqid() . '.' . $imageFileType; // Rename the file to prevent overwriting
            $uploadPath = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                // Insert recipe details into the database
                $stmt = $conn->prepare("INSERT INTO recipes (title, description, image) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $title, $description, $uploadPath);
                if ($stmt->execute()) {
                    $recipeId = $stmt->insert_id;
                    // Split and insert ingredients
                    $ingredientsArr = explode("\n", $ingredients);
                    foreach ($ingredientsArr as $ingredient) {
                        $ingredient = trim($ingredient);
                        $stmt = $conn->prepare("INSERT INTO ingredients (recipe_id, ingredient) VALUES (?, ?)");
                        $stmt->bind_param("is", $recipeId, $ingredient);
                        $stmt->execute();
                    }
                    // Split and insert instructions
                    $instructionsArr = explode("\n", $instructions);
                    foreach ($instructionsArr as $index => $instruction) {
                        $instruction = trim($instruction);
                        $stmt = $conn->prepare("INSERT INTO instructions (recipe_id, step_number, instruction) VALUES (?, ?, ?)");
                        $stmt->bind_param("iis", $recipeId, $index + 1, $instruction);
                        $stmt->execute();
                    }
                    echo "Recipe added successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Only image files (JPG, JPEG, PNG, GIF) are allowed.";
        }
    } else {
        echo "File is not an image.";
    }
} else {
    echo "Invalid request.";
}
$conn->close();
?>
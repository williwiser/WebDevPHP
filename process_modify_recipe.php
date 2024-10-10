<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();

// Start output buffering
ob_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'editor') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

// Check if all required fields are present
if (!isset($_POST['id'], $_POST['title'], $_POST['description'], $_POST['ingredients'], $_POST['instructions'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

$recipeId = intval($_POST['id']);
$title = $_POST['title'];
$description = $_POST['description'];
$ingredients = $_POST['ingredients'];
$instructions = $_POST['instructions'];
$currentImage = $_POST['currentImage'] ?? '';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'recipe_website_schema');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Process the image if a new one is uploaded
$imagePath = $currentImage; // Default to the existing image path
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    
    // Move the uploaded file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to upload image"]);
        exit;
    }
}

// Update the recipe in the database
$stmt = $conn->prepare("UPDATE recipes SET title = ?, description = ?, image = ? WHERE recipe_id = ?");
$stmt->bind_param("sssi", $title, $description, $imagePath, $recipeId);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to update recipe details: " . $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Update ingredients and instructions (assumes these are in separate tables)
// Delete existing entries first (you may adjust this part according to your schema)
$stmt = $conn->prepare("DELETE FROM ingredients WHERE recipe_id = ?");
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM instructions WHERE recipe_id = ?");
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$stmt->close();

// Insert updated ingredients
$ingredientList = explode("\n", $ingredients);
$stmt = $conn->prepare("INSERT INTO ingredients (recipe_id, ingredient) VALUES (?, ?)");
foreach ($ingredientList as $ingredient) {
    $stmt->bind_param("is", $recipeId, trim($ingredient));
    $stmt->execute();
}
$stmt->close();

// Insert updated instructions
$instructionList = explode("\n", $instructions);
$stmt = $conn->prepare("INSERT INTO instructions (recipe_id, instruction, step_number) VALUES (?, ?, ?)");
$stepNumber = 1;
foreach ($instructionList as $instruction) {
    $stmt->bind_param("isi", $recipeId, trim($instruction), $stepNumber);
    $stmt->execute();
    $stepNumber++;
}
$stmt->close();

$conn->close();

// Clean the output buffer
ob_clean();

// Return a success response
echo json_encode(["success" => true]);

// Flush the buffer and end output buffering
ob_end_flush();
?>

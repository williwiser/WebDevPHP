<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'editor') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

if (isset($_GET['id'])) {
    $recipeId = intval($_GET['id']);

    // Database connection
    $conn = new mysqli('CS3-DEV.ICT.RU.AC.ZA', 'TheOGs', 'M7fiB7C6', 'theogs');
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["error" => "Database connection failed"]);
        exit;
    }

    // Fetch recipe details including the image URL
    $stmt = $conn->prepare("SELECT title, description, image FROM recipes WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $stmt->bind_result($title, $description, $image);
    $stmt->fetch();
    $stmt->close();

    // Fetch ingredients
    $ingredients = [];
    $stmt = $conn->prepare("SELECT ingredient FROM ingredients WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $ingredients[] = $row['ingredient'];
    }
    $stmt->close();

    // Fetch instructions
    $instructions = [];
    $stmt = $conn->prepare("SELECT instruction FROM instructions WHERE recipe_id = ? ORDER BY step_number ASC");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $instructions[] = $row['instruction'];
    }
    $stmt->close();

    $conn->close();

    // Make sure to include a placeholder image if the image is empty
    $image = $image ?: 'path/to/placeholder-image.jpg';

    echo json_encode([
        "title" => $title,
        "description" => $description,
        "image" => $image,
        "ingredients" => $ingredients,
        "instructions" => $instructions
    ]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request: Recipe ID is missing"]);
}
?>
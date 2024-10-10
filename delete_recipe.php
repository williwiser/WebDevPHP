<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'editor') {
    http_response_code(403);
    exit("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'recipe_website_schema');
    if ($conn->connect_error) {
        http_response_code(500);
        exit("Connection failed: " . $conn->connect_error);
    }

    // Get the recipe ID from the query string
    if (isset($_GET['id'])) {
        $recipe_id = intval($_GET['id']);

        // Delete associated ingredients and instructions first due to foreign key constraints
        $stmt = $conn->prepare("DELETE FROM ingredients WHERE recipe_id = ?");
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM instructions WHERE recipe_id = ?");
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $stmt->close();

        // Delete the recipe
        $stmt = $conn->prepare("DELETE FROM recipes WHERE recipe_id = ?");
        $stmt->bind_param("i", $recipe_id);
        if ($stmt->execute()) {
            http_response_code(200);
            echo "Recipe deleted successfully";
        } else {
            http_response_code(500);
            echo "Error deleting recipe";
        }
        $stmt->close();
        $conn->close();
    } else {
        http_response_code(400);
        echo "Invalid request: Recipe ID is missing.";
    }
}
?>

<?php
header('Content-Type: application/json');
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Adjust if needed
$dbname = "recipe_website_schema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed.']));
}

$query = isset($_GET['query']) ? '%' . $_GET['query'] . '%' : '%';

// Fetch recipes matching the search query
$stmt = $conn->prepare("SELECT recipe_id, title, image, rating, description FROM recipes WHERE title LIKE ?");
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

$stmt->close();
$conn->close();

// Output the recipes as JSON
echo json_encode($recipes);

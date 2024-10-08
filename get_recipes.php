<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Adjust if needed
$dbname = "recipe_website_schema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed.']));
}

// Fetch all recipes
$sql = "SELECT recipe_id, title, image, rating, description FROM recipes";
$result = $conn->query($sql);

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

// Close the connection
$conn->close();

// Output the recipes as JSON
echo json_encode($recipes);
?>

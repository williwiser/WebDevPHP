<?php
header('Content-Type: application/json');

// Database connection
$servername = "CS3-DEV.ICT.RU.AC.ZA";
$username = "TheOGs";
$password = "M7fiB7C6";
$dbname = "theogs";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a search query is provided
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($query === '') {
    // If no search query, return the top 20 recipes
    $stmt = $conn->prepare("SELECT * FROM recipes ORDER BY recipe_id DESC LIMIT 20");
} else {
    // If a search query is provided, search for matching recipes
    $searchTerm = '%' . $query . '%';
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE ? ORDER BY recipe_id DESC LIMIT 20");
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($recipes);
?>
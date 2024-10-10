<?php
header('Content-Type: application/json');

// Database connection
$servername = "CS3-DEV.ICT.RU.AC.ZA";
$username = "TheOGs";
$password = "M7fiB7C6";
$dbname = "theogs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed.']));
}

// Get the search query parameter from the URL
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : "";

// Prepare the SQL statement with a LIKE clause if there's a search query
$sql = "SELECT recipe_id, title, image, rating, description FROM recipes";
if (!empty($searchQuery)) {
    $sql .= " WHERE title LIKE ? OR description LIKE ?";
}

$stmt = $conn->prepare($sql);

if (!empty($searchQuery)) {
    // Bind the search term with wildcards for partial matching
    $searchTerm = '%' . $searchQuery . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
}

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Output the recipes as JSON
echo json_encode($recipes);
?>
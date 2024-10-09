<?php
// Include your database connection file
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$searchTerm = '';
if (isset($_POST['query'])) {
    $searchTerm = $_POST['query'];
}

// Prepare SQL query
$sql = "SELECT * FROM recipes WHERE title LIKE ?";
$stmt = $conn->prepare($sql);
$likeTerm = "%" . $searchTerm . "%";
$stmt->bind_param("s", $likeTerm);
$stmt->execute();
$result = $stmt->get_result();

// Output results as HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="unique-card">';
        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
        echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
        echo '<p>Rating: ' . htmlspecialchars($row['rating']) . '</p>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>No recipes found.</p>';
}

$stmt->close();
$conn->close();
?>

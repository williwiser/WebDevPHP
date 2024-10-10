<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database"; // Ensure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query based on whether a search term is provided
$searchTerm = isset($_POST['query']) ? $_POST['query'] : ''; // Get the search term from POST request
$recipes = [];
$noRecipesMessage = "";

if ($searchTerm) {
    $sql = "SELECT 
                recipes.title,
                recipes.description,
                recipes.image,
                recipes.rating
            FROM recipes 
            WHERE recipes.title LIKE ? OR recipes.description LIKE ?";
    
    $stmt = $conn->prepare($sql);
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("ss", $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT 
                recipes.title,
                recipes.description,
                recipes.image,
                recipes.rating
            FROM recipes";
    
    $result = $conn->query($sql);
}

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
} else {
    $noRecipesMessage = "No recipes found.";
}

$conn->close();

// Only return the HTML for the recipes
if (!empty($recipes)): ?>
    <div class="alphacard-container"> <!-- Apply the "alphacard-container" class for grid layout -->
        <?php foreach ($recipes as $row): ?>
            <div class="alphacard"> <!-- Apply the "alphacard" class for individual cards -->
                <img class="alphacard__image" src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>"> <!-- Image class -->
                <div class="alphacard__overlay"> <!-- Overlay class -->
                    <div class="alphacard__header">
                        <h2 class="alphacard__title"><?php echo htmlspecialchars($row['title']); ?></h2> <!-- Title class -->
                        <div class="alphacard__rating">
                            <?php
                            $rating = round($row['rating']); // Round to the nearest whole number
                            for ($i = 1; $i <= 5; $i++): 
                                if ($i <= $rating): ?>
                                    <span class="alphacard__star filled">★</span> <!-- Filled star -->
                                <?php else: ?>
                                    <span class="alphacard__star">☆</span> <!-- Empty star -->
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                    <p class="alphacard__description"><?php echo htmlspecialchars($row['description']); ?></p> <!-- Description class -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p><?php echo htmlspecialchars($noRecipesMessage); ?></p> <!-- Use htmlspecialchars for safety -->
<?php endif; ?>

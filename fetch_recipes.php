<?php
session_start();

// Database connection
$servername = "CS3-DEV.ICT.RU.AC.ZA";
$username = "TheOGs";
$password = "M7fiB7C6";
$dbname = "theogs"; // Ensure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query based on whether a search term is provided
$searchTerm = isset($_POST['query']) ? trim($_POST['query']) : ''; // Get the search term from POST request
$recipes = [];
$noRecipesMessage = "";

if ($searchTerm) {
    $sql = "SELECT 
                title,
                description,
                image,
                rating
            FROM recipes 
            WHERE title LIKE ? OR description LIKE ?";

    $stmt = $conn->prepare($sql);
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("ss", $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT 
                title,
                recipe_id,
                description,
                image,
                rating
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

// Output the recipes as HTML
if (!empty($recipes)): ?>
    <div class="alphacard-container">
        <?php foreach ($recipes as $row): ?>
            <a href="recipe-detail.php?recipe_id=<?php echo $row['recipe_id'] ?>" class="alphacard">
                <img class="alphacard__image" src="<?php echo htmlspecialchars($row['image']); ?>"
                    alt="<?php echo htmlspecialchars($row['title']); ?>">
                <div class="alphacard__overlay">
                    <div class="alphacard__header">
                        <h2 class="alphacard__title"><?php echo htmlspecialchars($row['title']); ?></h2>
                        <div class="alphacard__rating">
                            <?php
                            $rating = round($row['rating']); // Round to the nearest whole number
                            for ($i = 1; $i <= 5; $i++):
                                if ($i <= $rating): ?>
                                    <span class="alphacard__star filled">★</span>
                                <?php else: ?>
                                    <span class="alphacard__star">☆</span>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                    <p class="alphacard__description"><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p><?php echo htmlspecialchars($noRecipesMessage); ?></p>
<?php endif; ?>
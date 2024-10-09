<?php
session_start();

if (isset($_GET['recipe_id'])) {
  $recipe_id = intval($_GET['recipe_id']);

  // Database connection
  $conn = new mysqli('localhost', 'root', '', 'recipe_website_schema');
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch recipe
  $stmt = $conn->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
  $stmt->bind_param("i", $recipe_id);
  $stmt->execute();
  $recipeResult = $stmt->get_result();
  $recipe = $recipeResult->fetch_assoc();
  $stmt->close();

  if ($recipe) {
    // Fetch ingredients
    $stmt = $conn->prepare("SELECT ingredient FROM ingredients WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $ingredientsResult = $stmt->get_result();
    $ingredients = [];
    while ($row = $ingredientsResult->fetch_assoc()) {
      $ingredients[] = $row['ingredient'];
    }
    $stmt->close();

    // Fetch instructions
    $stmt = $conn->prepare("SELECT instruction FROM instructions WHERE recipe_id = ? ORDER BY step_number ASC");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $instructionsResult = $stmt->get_result();
    $instructions = [];
    while ($row = $instructionsResult->fetch_assoc()) {
      $instructions[] = $row['instruction'];
    }
    $stmt->close();

    $conn->close();
  } else {
    $error_message = "Recipe not found.";
  }
} else {
  $error_message = "No recipe specified.";
}
?>

<!DOCTYPE html>
<html lang="e">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe-Detail | Recipes</title>
  <link rel="stylesheet" type="text/css" href="style.css" /> <!--links css with page-->
</head>

<body>
  <!--start navbar-->
  <nav class="navbar">
    <ul class="nav-list">
      <li class="nav-item">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="about.php" class="nav-link">About</a>
      </li>
      <li class="nav-item">
        <a href="recipes.php" class="nav-link active">Recipes</a>
      </li>
      <li class="nav-item">
        <a href="contact.php" class="nav-link">Contact</a>
      </li>
      <?php if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && isset($_SESSION['loggedin'])) { ?>
        <li class="nav-item">
          <a href="account.php" class="nav-link">My Account</a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a href="signIn.php" class="nav-link">Sign In</a>
        </li>
      <?php } ?>
    </ul>
  </nav>
  <!--end navbar-->
  <!--start Sidebar-->
  <!-- Toggle checkbox (hidden) -->
  <input type="checkbox" id="toggle-sidebar" class="toggle-checkbox">

  <!-- Label acting as a button -->
  <label for="toggle-sidebar" class="toggle-button"></label>
  <div class="sidebar">
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </div>
  <!--end Sidebar-->
  <?php if (isset($error_message)): ?>
    <p><?php echo htmlspecialchars($error_message); ?></p>
  <?php else: ?>
    <!-- Display recipe details -->
    <header id="myHeader">
      <h1 id="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h1>
    </header>

    <section class="recipe-Section">
      <p id="recipe-description"><?php echo htmlspecialchars($recipe['description']); ?></p>
      <img id="recipe-detail" src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image">

      <h2>Ingredients</h2>
      <ul id="recipe-ingredients">
        <?php foreach ($ingredients as $ingredient): ?>
          <li><?php echo htmlspecialchars($ingredient); ?></li>
        <?php endforeach; ?>
      </ul>

      <h2>Instructions</h2>
      <ol id="recipe-instructions">
        <?php foreach ($instructions as $instruction): ?>
          <li><?php echo htmlspecialchars($instruction); ?></li>
        <?php endforeach; ?>
      </ol>
    </section>
  <?php endif; ?>

  <script src="navigator-info.js"></script>
</body>

</html>
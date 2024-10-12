<?php
session_start();

if (isset($_GET['recipe_id'])) {
  $recipe_id = intval($_GET['recipe_id']);

  // Database connection
  $servername = "CS3-DEV.ICT.RU.AC.ZA";
  $username = "TheOGs";
  $password = "M7fiB7C6";
  $dbname = "theogs";
  $conn = new mysqli($servername, $username, $password, $dbname);
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
      $ingredients[] = htmlspecialchars($row['ingredient']);
    }
    $stmt->close();

    // Fetch instructions
    $stmt = $conn->prepare("SELECT instruction FROM instructions WHERE recipe_id = ? ORDER BY step_number ASC");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $instructionsResult = $stmt->get_result();
    $instructions = [];
    while ($row = $instructionsResult->fetch_assoc()) {
      $instructions[] = htmlspecialchars($row['instruction']);
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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe-Detail | Recipes</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
  <!-- Navbar -->
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
      <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor' && isset($_SESSION['loggedin'])): ?>
        <span>|</span>
        <li class="nav-item"><a href="manage_recipes.php" class="nav-link">Manage Recipes</a></li>
      <?php endif; ?>
      <span>|</span>
      <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id']) && isset($_SESSION['loggedin'])) { ?>
        <li class="nav-item">
          <a href="account.php" class="nav-link">My Account <i class="fa-solid fa-user"></i></a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a href="signIn.php" class="nav-link">Sign In</a>
        </li>
      <?php } ?>
    </ul>
  </nav>

  <!-- Sidebar -->
  <input type="checkbox" id="toggle-sidebar" class="toggle-checkbox">
  <label for="toggle-sidebar" class="toggle-button"></label>
  <div class="sidebar">
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </div>

  <?php if (isset($error_message)): ?>
    <p><?php echo htmlspecialchars($error_message); ?></p>
  <?php else: ?>
    <!-- Display recipe details -->
    <header id="myHeader"
      style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.7)), url('<?php echo htmlspecialchars($recipe['image']); ?>'); background-size: cover;">
      <h1 id="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h1>
    </header>

    <section class="recipe-sn">
      <section class="container">
        <h1 id="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h1>
        <p id="recipe-description"><?php echo htmlspecialchars($recipe['description']); ?></p>
        <hr>
        <article>
          <hgroup>
            <h2>Ingredients</h2>
            <ul id="recipe-ingredients">
              <?php foreach ($ingredients as $ingredient): ?>
                <li><?php echo $ingredient; ?></li>
              <?php endforeach; ?>
            </ul>
          </hgroup>

          <hgroup>
            <h2>Instructions</h2>
            <ol id="recipe-instructions">
              <?php foreach ($instructions as $instruction): ?>
                <li><?php echo $instruction; ?></li>
              <?php endforeach; ?>
            </ol>
          </hgroup>

          <img id="recipe-detail" src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image">
        </article>
      </section>
    </section>
  <?php endif; ?>
  <footer>
    <section class="container">
      <p>&copy; The OG's 2024. All rights reserved.</p>

      <!--Begin social buttons-->

      <!--TODO replace links with relevant locations-->
      <div class="social-buttons">
        <a href="https://www.instagram.com" class="social-button instagram" aria-label="Instagram" target="_blank"></a>
        <a href="https://www.facebook.com" class="social-button facebook" aria-label="Facebook" target="_blank"></a>
        <a href="https://www.youtube.com" class="social-button youtube" aria-label="YouTube" target="_blank"></a>
        <a href="https://www.github.com" class="social-button github" aria-label="GitHub" target="_blank"></a>
      </div>
      <!--End social buttons-->


    </section>
  </footer>

  <script src="navigator-info.js"></script>
</body>

</html>
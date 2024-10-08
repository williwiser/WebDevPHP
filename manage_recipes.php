<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'editor') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Recipes | Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
            <li class="nav-item"><a href="recipes.php" class="nav-link">Recipes</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            <li class="nav-item"><a href="signIn.php" class="nav-link active">Sign In</a></li>
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor'): ?>
              <li class="nav-item"><a href="manage_recipes.php" class="nav-link">Manage Recipes</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <header>
        <h1>Manage Recipes</h1>
        <input type="text" id="search-bar" placeholder="Search for a recipe..." onkeyup="searchRecipes()" />
    </header>

    <section class="manage-options">
        <button onclick="window.location.href='add_recipe.php'">Add Recipe</button>
        <button onclick="window.location.href='modify_recipe.php'">Modify Recipe</button>
        <button onclick="window.location.href='delete_recipe.php'">Delete Recipe</button>
    </section>

    <div id="search-results"></div>

    <script src="manage_recipes.js"></script>
</body>
</html>

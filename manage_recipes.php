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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="about.php" class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a href="recipes.php" class="nav-link">Recipes</a>
            </li>
            <li class="nav-item">
                <a href="contact.php" class="nav-link">Contact</a>
            </li>
            <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id']) && isset($_SESSION['loggedin'])) { ?>
                <li class="nav-item">
                    <a href="account.php" class="nav-link">My Account</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a href="signIn.php" class="nav-link">Sign In</a>
                </li>
            <?php } ?>
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor'): ?>
                <li class="nav-item"><a href="manage_recipes.php" class="nav-link active">Manage Recipes</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <header class="manage-recipes-header">
        <h1>Manage Recipes</h1>
        <input type="text" id="search-bar" class="manage-recipes-search-bar" placeholder="Search for a recipe..."
            onkeyup="searchRecipes()" />
    </header>

    <section class="manage-options">
        <button onclick="window.location.href='add_recipe.php'">Add Recipe</button>
        <button onclick="window.location.href='modify_recipe.php'">Modify Recipe</button>
        <button onclick="window.location.href='delete_recipe.php'">Delete Recipe</button>
    </section>

    <div id="search-results" class="manage-recipes-container"></div> <!-- Container for search results -->


    <script src="manage_recipes.js"></script>
</body>

</html>
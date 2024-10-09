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
    <title>Add Recipe | Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
                <li class="nav-item"><a href="manage_recipes.php" class="nav-link">Manage Recipes</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Recipe Form -->
    <main>
        <form action="add_recipe.php" method="post" enctype="multipart/form-data" class="recipe-form">
            <h1>Add Recipe</h1>
            <label for="title">Recipe Title</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Recipe Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="ingredients">Ingredients (one per line)</label>
            <textarea id="ingredients" name="ingredients" rows="4" required></textarea>

            <label for="instructions">Instructions (one per line)</label>
            <textarea id="instructions" name="instructions" rows="4" required></textarea>

            <label for="image">Recipe Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Add Recipe</button>
        </form>
    </main>

    <script src="add_recipe.js"></script> <!-- If there's any JavaScript specific for this page -->
    <script>
        // Client-side validation (additional layer)
        document.querySelector('.recipe-form').addEventListener('submit', function(event) {
            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];

            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!allowedTypes.includes(file.type) || file.size > maxSize) {
                    alert("Invalid file type or file size exceeds 2MB.");
                    event.preventDefault();
                }
            }
        });
    </script>
</body>

</html>


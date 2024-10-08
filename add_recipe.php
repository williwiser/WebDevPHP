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
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <nav class="navbar">
        <!-- Include navigation -->
    </nav>

    <h1>Add a New Recipe</h1>
    <form action="process_add_recipe.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Recipe Title" required />
        <textarea name="description" placeholder="Recipe Description" required></textarea>
        <textarea name="ingredients" placeholder="Ingredients (one per line)" required></textarea>
        <textarea name="instructions" placeholder="Instructions (one per line)" required></textarea>
        <input type="file" name="image" accept="image/*" required />
        <button type="submit">Add Recipe</button>
    </form>
</body>
</html>

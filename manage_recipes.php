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
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor'): ?>
                <li class="nav-item"><a href="manage_recipes.php" class="nav-link  active">Manage Recipes</a></li>
            <?php endif; ?>
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

    <header class="manage-recipes-header">
        <h1>Manage Recipes</h1>
        <input type="text" id="search-bar" class="manage-recipes-search-bar" placeholder="Search for a recipe..." />
    </header>

    <section class="manage-options">
        <button onclick="window.location.href='add_recipe.php'">Add Recipe</button>
    </section>

    <div id="search-results" class="manage-recipes-container"></div>

    <!-- Modify Recipe Modal -->
    <!-- Modify Recipe Modal -->
    <div id="modifyModal" class="modal">
        <div class="modal-content">
            <h2>Modify Recipe</h2>
            <form id="modify-recipe-form" class="modify-form">
                <input type="hidden" id="modify-recipe-id" name="modify-recipe-id">

                <label for="modify-title">Recipe Title</label>
                <input type="text" id="modify-title" name="modify-title" class="input-field" required>

                <label for="modify-description">Description</label>
                <textarea id="modify-description" name="modify-description" rows="4" class="textarea-field"
                    required></textarea>

                <label for="modify-ingredients">Ingredients (one per line)</label>
                <textarea id="modify-ingredients" name="modify-ingredients" rows="4" class="textarea-field"
                    required></textarea>

                <label for="modify-instructions">Instructions (one per line)</label>
                <textarea id="modify-instructions" name="modify-instructions" rows="4" class="textarea-field"
                    required></textarea>

                <!-- Current Image Preview -->
                <div id="current-image-container" style="margin-bottom: 15px;">
                    <label>Current Image:</label>
                    <img id="modify-current-image" src="" alt="Current Recipe Image"
                        style="max-width: 100%; height: auto;">
                </div>

                <label for="modify-image">Recipe Image (optional)</label>
                <input type="file" id="modify-image" name="modify-image" class="input-file">

                <div class="modal-buttons">
                    <button type="button" id="modify-save" class="save-btn">Save Changes</button>
                    <button type="button" id="modify-cancel" class="cancel-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this recipe?</p>
            <button id="confirmYes" class="confirm-btn">Yes</button>
            <button id="confirmNo" class="cancel-btn">No</button>
        </div>
    </div>

    <script src="manage_recipes.js"></script>
</body>

</html>
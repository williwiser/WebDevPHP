<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recipes | Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <a href="account.php" class="nav-link">My Account <i class="fa fa-user"></i></a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a href="signIn.php" class="nav-link">Sign In</a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <header>
        <h1>Explore Recipes</h1>
        <p>Check out our diverse catalogue of recipes</p>
        <input type="text" id="search-bar" class="manage-recipes-search-bar" placeholder="Search for a recipe..." />
    </header>

    <div id="search-recipes" class="recipes-container"></div>

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

    <script src="display_recipes.js"></script>

    <!--main content sections here-->
    <footer>
        <section class="container">
            <p>&copy; The OG's 2024. All rights reserved.</p>
            <!--Begin social buttons-->

            <!--TODO replace links with relevant locations-->
            <div class="social-buttons">
                <a href="https://www.instagram.com" class="social-button instagram" aria-label="Instagram"
                    target="_blank"></a>
                <a href="https://www.facebook.com" class="social-button facebook" aria-label="Facebook"
                    target="_blank"></a>
                <a href="https://www.youtube.com" class="social-button youtube" aria-label="YouTube"
                    target="_blank"></a>
                <a href="https://www.github.com" class="social-button github" aria-label="GitHub" target="_blank"></a>
            </div>
            <!--End social buttons-->
        </section>
    </footer>

</body>

</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recipes | Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item"><a href="recipes.php" class="nav-link active">Recipes</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            <?php if (isset($_SESSION['email'], $_SESSION['user_id'], $_SESSION['loggedin'])): ?>
                <li class="nav-item"><a href="account.php" class="nav-link">My Account</a></li>
            <?php else: ?>
                <li class="nav-item"><a href="signIn.php" class="nav-link">Sign In</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor'): ?>
                <li class="nav-item"><a href="manage_recipes.php" class="nav-link">Manage Recipes</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <header>
        <h1>Explore Recipes</h1>
        <p>Browse through our extensive collection of recipes shared by food enthusiasts like you!</p>
        <section class="search-bar">
            <input type="text" id="searchRecipeTab" placeholder="Enter recipe name" />
            <button id="searchButton">Search</button>
            <button id="seeAllButton">See All</button> <!-- See All button added -->
        </section>
    </header>



    <section id="recipeResults">
        <!-- Recipe Cards Container -->
        <div class="unique-recipe-cards">
            <!-- Initial recipe cards can be displayed here if needed -->
        </div>
    </section>

    <script>
        document.getElementById("searchButton").addEventListener("click", function () {
            const searchQuery = document.getElementById("searchRecipeTab").value;

            // AJAX request to fetch_recipes.php for processing
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_recipes.php", true); // Send to the new PHP file for processing
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (this.status === 200) {
                    // Update only the recipe results section
                    document.querySelector("#recipeResults .unique-recipe-cards").innerHTML = this.responseText;
                } else {
                    document.querySelector("#recipeResults .unique-recipe-cards").innerHTML = "<p>No recipes found.</p>";
                }
            };

            xhr.send("query=" + encodeURIComponent(searchQuery));
        });

        // Add event listener for See All button
        document.getElementById("seeAllButton").addEventListener("click", function () {
            // AJAX request to fetch_recipes.php for all recipes
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_recipes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (this.status === 200) {
                    // Update only the recipe results section
                    document.querySelector("#recipeResults .unique-recipe-cards").innerHTML = this.responseText;
                } else {
                    document.querySelector("#recipeResults .unique-recipe-cards").innerHTML = "<p>No recipes found.</p>";
                }
            };

            xhr.send(); // No query parameter needed for all recipes
        });
    </script>


    <footer>
        <section class="container">
            <p>&copy; The OG's 2024. All rights reserved.</p>
            <div class="social-buttons">
                <a href="https://www.instagram.com" class="social-button instagram" aria-label="Instagram"
                    target="_blank"></a>
                <a href="https://www.facebook.com" class="social-button facebook" aria-label="Facebook"
                    target="_blank"></a>
                <a href="https://www.youtube.com" class="social-button youtube" aria-label="YouTube"
                    target="_blank"></a>
                <a href="https://www.github.com" class="social-button github" aria-label="GitHub" target="_blank"></a>
            </div>
        </section>
    </footer>
</body>

</html>
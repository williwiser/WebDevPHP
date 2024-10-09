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
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

       

        /* Header Styles */
        header {
            background: url('img/avocado-bg.jpg') no-repeat center center/cover;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        header h1 {
            font-size: 48px;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Search Bar Styles */
        #search-bar {
            padding: 12px;
            width: 60%;
            max-width: 600px;
            border-radius: 25px;
            border: none;
            margin-top: 20px;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        #search-bar:focus {
            outline: none;
            border: 2px solid #ccc;
        }

        /* Manage Options Button Styles */
        .manage-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            padding: 20px;
        }

        .manage-options button {
            padding: 12px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .manage-options button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .manage-options button:active {
            background-color: #1e7e34;
        }

        /* Search Results Styles */
        #search-results {
            margin-top: 20px;
            padding: 20px;
        }

        #search-results div {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #search-results div:hover {
            background-color: #f1f1f1;
        }
    </style>
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
<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'editor') {
    header("Location: index.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "recipe_website_schema";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $ingredients = explode("\n", $_POST['ingredients']);
    $instructions = explode("\n", $_POST['instructions']);
    $imageFile = $_FILES['image'];

    // Check if an image was uploaded
    if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $imageFile['tmp_name'];
        $originalFileName = $imageFile['name'];
        $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        // Validate the file type (e.g., jpg, png, gif)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            // Generate a unique name for the file using timestamp and uniqid
            $uniqueFileName = 'img_' . time() . '_' . uniqid() . '.' . $imageFileType;
            $targetFile = 'uploads/' . $uniqueFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($imageTmpPath, $targetFile)) {
                // Insert the recipe into the database
                $stmt = $conn->prepare("INSERT INTO recipes (title, image, description, rating) VALUES (?, ?, ?, 0)");
                $stmt->bind_param("sss", $title, $targetFile, $description);
                $stmt->execute();

                $recipeId = $stmt->insert_id;

                // Insert ingredients into the database as individual rows
                foreach ($ingredients as $ingredient) {
                    $ingredient = trim($ingredient);
                    if (!empty($ingredient)) {
                        $stmt = $conn->prepare("INSERT INTO ingredients (recipe_id, ingredient) VALUES (?, ?)");
                        $stmt->bind_param("is", $recipeId, $ingredient);
                        $stmt->execute();
                    }
                }

                // Insert instructions into the database as individual rows
                foreach ($instructions as $index => $instruction) {
                    $instruction = trim($instruction);
                    if (!empty($instruction)) {
                        $stepNumber = $index + 1;
                        $stmt = $conn->prepare("INSERT INTO instructions (recipe_id, step_number, instruction) VALUES (?, ?, ?)");
                        $stmt->bind_param("iis", $recipeId, $stepNumber, $instruction);
                        $stmt->execute();
                    }
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();

                // Redirect or display success message
                header("Location: manage_recipes.php");
                exit;
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No image uploaded.";
    }
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
    <nav class="navbar">
    <ul class="nav-list">
      <li class="nav-item">
        <a href="index.php" class="nav-link active">Home</a>
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

    <main>
        <form action="add_recipe.php" method="post" enctype="multipart/form-data" class="recipe-form">
            <h1>Add Recipe</h1>
            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php elseif (!empty($success)): ?>
                <p class="success"><?= $success ?></p>
            <?php endif; ?>
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



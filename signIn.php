<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_website_schema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $password = "";
$emailErr = $passwordErr = "";
$loginErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"])) {
    $emailErr = "* Email required";
  } else {
    $email = cleanInput($_POST["email"]);
  }
  if (empty($_POST["password"])) {
    $passwordErr = "* Password required";
  } else {
    $password = cleanInput($_POST["password"]);
  }

  // Proceed only if no validation errors
  if (empty($emailErr) && empty($passwordErr)) {
    // Prepare and bind to check if the user exists
    $stmt = $conn->prepare("SELECT user_id, password, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If user is found
    if ($stmt->num_rows > 0) {
      // Bind the result variables
      $stmt->bind_result($userId, $hashedPassword, $userType);
      $stmt->fetch();

      // Verify the password
      if (password_verify($password, $hashedPassword)) {
        // Password is correct - start a session
        $_SESSION["loggedin"] = true;
        $_SESSION["user_id"] = $userId;
        $_SESSION["email"] = $email;
        $_SESSION["user_type"] = $userType;

        // Debugging - Print session variables
        // echo "Session User Type: " . $_SESSION["user_type"];

        // Redirect to the homepage
        header("Location: index.php");
        exit;
      } else {
        $loginErr = "Invalid password. Please try again.";
      }
    } else {
      $loginErr = "No account found with that email.";
    }

    // Close the statement
    $stmt->close();
  }
}

// Close the connection
$conn->close();

function cleanInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In | Recipes</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body id="signIn">
  <nav class="navbar">
    <ul class="nav-list">
      <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
      <li class="nav-item"><a href="recipes.php" class="nav-link">Recipes</a></li>
      <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
      <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id']) && isset($_SESSION['loggedin'])) { ?>
        <li class="nav-item">
          <a href="account.php" class="nav-link">My Account</a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a href="signIn.php" class="nav-link active">Sign In</a>
        </li>
      <?php } ?>
      <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor'): ?>
        <li class="nav-item"><a href="manage_recipes.php" class="nav-link">Manage Recipes</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <main>
    <section id="login-sn">
      <div class="bg">
        <section class="container">
          <form class="no-hover-card" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Sign In</h1>
            <p>Access your account and start sharing recipes</p>

            <!-- Display error messages -->
            <?php if (!empty($loginErr)): ?>
              <p class="error"><?php echo $loginErr; ?></p>
            <?php endif; ?>

            <input placeholder="Email" type="email" id="email" name="email"
              value="<?php echo htmlspecialchars($email); ?>" />
            <span class="error"><?php echo $emailErr ?></span>

            <input placeholder="Password" type="password" id="password" name="password" />
            <span class="error"><?php echo $passwordErr ?></span>

            <input class="btn" type="submit" value="Sign In" />
            <p>New here? <a href="register.php">Sign Up</a></p>
          </form>
        </section>
      </div>
    </section>
  </main>
</body>

</html>
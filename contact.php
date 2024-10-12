<?php
session_start();
?>
<?php

$servername = "CS3-DEV.ICT.RU.AC.ZA";
$username = "TheOGs";
$password = "M7fiB7C6";
$dbname = "theogs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Clean and assign form inputs
  $name = cleanInput($_POST["name"]);
  $email = cleanInput($_POST["email"]);
  $message = cleanInput($_POST["message"]);

  // Validate inputs
  if (empty($name)) {
    $nameErr = "* Name required";
  }
  if (empty($email)) {
    $emailErr = "* Email required";
  }
  if (empty($message)) {
    $messageErr = "* You can't send an empty message.";
  }

  // Proceed only if no validation errors
  if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement
    if ($stmt->execute()) {
      echo `<script>
              alert("Thanks for reaching out! We'll get back to you soon.");
              window.location.href = 'contact.php'; // Replace with the actual login page URL
            </script>`;
    } else {
      echo `<script>
              alert("Hmm, something went wrong, try again later.");
              window.location.href = 'contact.php'; // Replace with the actual login page URL
            </script>`;
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
  <!--Makes website more compatible on mobile browsers-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Home | Recipes</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <script src="navigator-info.js"></script>
  <!--start navbar-->
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
        <a href="contact.php" class="nav-link active">Contact</a>
      </li>
      <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'editor' && isset($_SESSION['loggedin'])): ?>
        <span>|</span>
        <li class="nav-item"><a href="manage_recipes.php" class="nav-link">Manage Recipes</a></li>
      <?php endif; ?>
      <span>|</span>
      <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id']) && isset($_SESSION['loggedin'])) { ?>
        <li class="nav-item">
          <a href="account.php" class="nav-link acc">My Account <i class="fa fa-user"></i></a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a href="signIn.php" class="nav-link">Sign In</a>
        </li>
      <?php } ?>
    </ul>
  </nav>

  <!--start Sidebar-->
  <!-- Toggle checkbox (hidden) -->
  <input type="checkbox" id="toggle-sidebar" class="toggle-checkbox" />

  <!-- Label acting as a button -->
  <label for="toggle-sidebar" class="toggle-button"></label>
  <div class="sidebar">
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </div>
  <!--end Sidebar-->

  <header>
    <h1>Contact Us</h1>
    <p>
      If you have any questions or feedback, feel free to reach out to us!
    </p>
  </header>

  <main>
    <section id="contact-sn">
      <section class="container">
        <form class="no-hover-card" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <h2>Get in Touch</h2>
          <label>Name:
            <input type="text" id="name" name="name" />
          </label>
          <span class="error"><?php echo $nameErr ?></span>

          <label for="email">Email:
            <input type="email" id="email" name="email" />
          </label>
          <span class="error"><?php echo $emailErr ?></span>

          <label for="message">Message:
            <textarea id="message" name="message" rows="4" cols="50"></textarea>
          </label>
          <span class="error"><?php echo $messageErr ?></span>

          <input class="btn" type="submit" value="Send Message" />
        </form>
      </section>
    </section>
  </main>

  <footer>
    <section class="container">
      <p>&copy; The OG's 2024. All rights reserved.</p>
      <!--Begin social buttons-->

      <!--TODO replace links with relevant locations-->
      <div class="social-buttons">
        <a href="https://www.instagram.com" class="social-button instagram" aria-label="Instagram" target="_blank"></a>
        <a href="https://www.facebook.com" class="social-button facebook" aria-label="Facebook" target="_blank"></a>
        <a href="https://www.youtube.com" class="social-button youtube" aria-label="YouTube" target="_blank"></a>
        <a href="https://www.github.com" class="social-button github" aria-label="GitHub" target="_blank"></a>
      </div>
      <!--End social buttons-->
    </section>
  </footer>
</body>

</html>
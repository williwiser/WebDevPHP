<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | Recipes</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body id="signIn">
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
          <a href="signIn.php" class="nav-link active">Sign In</a>
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

  <main>
    <section id="login-sn">
      <div class="bg">
        <section class="container">
          <form class="no-hover-card" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            $userName = $password = $email = $userType = "";
            $userNameErr = $passwordErr = $emailErr = $termsErr = $userTypeErr = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              // Clean and assign form inputs
              $userName = cleanInput($_POST["username"]);
              $email = cleanInput($_POST["email"]);
              $password = cleanInput($_POST["password"]);
              $userType = isset($_POST["user_type"]) ? cleanInput($_POST["user_type"]) : '';
              $terms = isset($_POST["terms"]);

              // Validate inputs
              if (empty($userName)) {
                $userNameErr = "* User name required";
              }
              if (empty($email)) {
                $emailErr = "* Email required";
              }
              if (empty($password)) {
                $passwordErr = "* Password required";
              }
              if (empty($userType)) {
                $userTypeErr = "* User type required";
              }
              if (!$terms) {
                $termsErr = "Please agree to the terms and conditions to proceed.";
              }

              // Proceed only if no validation errors
              if (empty($userNameErr) && empty($emailErr) && empty($passwordErr) && empty($userTypeErr) && empty($termsErr)) {
                // Check if the email already exists in the database
                $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
                $checkEmail->bind_param("s", $email);
                $checkEmail->execute();
                $checkEmail->store_result();

                if ($checkEmail->num_rows > 0) {
                  echo "Email is already registered. Please use a different email.";
                } else {
                  // Hash the password securely
                  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                  // Prepare and bind
                  $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
                  $stmt->bind_param("ssss", $userName, $email, $hashedPassword, $userType);

                  // Execute the statement
                  if ($stmt->execute()) {
                    // Registration successful, now log the user in
                    session_start();
                    $_SESSION["user_id"] = $stmt->insert_id; // Get the ID of the inserted user
                    $_SESSION["username"] = $userName;
                    $_SESSION["user_type"] = $userType;

                    // Redirect to index.php
                    header("Location: signIn.php?accSuccessful=true");
                    exit;
                  } else {
                    echo "Error: " . $stmt->error;
                  }

                  // Close the statement
                  $stmt->close();
                }

                // Close the email check statement
                $checkEmail->close();
              } else {
                echo "All fields are required!";
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
            <h1>Sign Up</h1>
            <p>Sign up to share your favorite recipes.</p>

            <input placeholder="User Name" type="text" id="username" name="username" />
            <span class="error"><?php echo $userNameErr ?></span>

            <input placeholder="Email" type="email" id="email" name="email" />
            <span class="error"><?php echo $emailErr ?></span>

            <input placeholder="Password" type="password" id="password" name="password" />
            <span class="error"><?php echo $passwordErr ?></span>

            <select id="user_type" name="user_type">
              <option value="" disabled selected>User Type</option>
              <option value="normal">Normal</option>
              <option value="editor">Editor</option>
            </select>
            <span class="error"><?php echo $userTypeErr ?></span>
            <label class="terms" for="terms">
              <input type="checkbox" id="terms" name="terms" value="terms" />
              <span>I have read and understood the
                <a href="terms.html">terms and conditions</a>
              </span>
            </label>
            <span class="error termsErr"><?php echo $termsErr ?></span>
            <input class="btn" type="submit" value="Sign Up" />
            <p>Already have an account? <a href="signIn.php">Sign In</a></p>
          </form>
        </section>
      </div>
    </section>
  </main>
</body>

</html>
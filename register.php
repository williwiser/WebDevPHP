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
      <li class="nav-item">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="about.html" class="nav-link">About</a>
      </li>
      <li class="nav-item">
        <a href="recipes.php" class="nav-link">Recipes</a>
      </li>
      <li class="nav-item">
        <a href="contact.php" class="nav-link">Contact</a>
      </li>
      <li class="nav-item">
        <a href="signIn.php" class="nav-link active">Sign In</a>
      </li>
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

            
 $servername = "localhost";
 $username = "root";
 $password = ""; // Default password for XAMPP MySQL
 $dbname = "recipe_website_schema";
 
 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 
 // Check if the form is submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $user = $_POST['username'];
     $email = $_POST['email'];
     $pass = $_POST['password'];
 
     // Validate input (basic validation for example purposes)
     if (!empty($user) && !empty($email) && !empty($pass)) {
         // Check if the email already exists in the database
         $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
         $checkEmail->bind_param("s", $email);
         $checkEmail->execute();
         $checkEmail->store_result();
 
         if ($checkEmail->num_rows > 0) {
             echo "Email is already registered. Please use a different email.";
         } else {
             // Hash the password securely
             $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
 
             // Prepare and bind
             $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
             $stmt->bind_param("sss", $user, $email, $hashedPassword);
 
             // Execute the statement
             if ($stmt->execute()) {
                 echo "Registration successful!";
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
            $userName = $password = $email = "";
            $userNameErr = $passwordErr = $emailErr = $termsErr = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (empty($_POST["username"])) {
                $userNameErr = "* user name required";
              } else {
                $userName = cleanInput($_POST["username"]);
              }
              if (empty($_POST["email"])) {
                $emailErr = "* email required";
              } else {
                $email = cleanInput($_POST["email"]);
              }
              if (empty($_POST["password"])) {
                $passwordErr = "* password required";
              } else {
                $password = cleanInput($_POST["password"]);
              }
              if (!isset($_POST["terms"])) {
                $termsErr = "Please agree to the terms and conditions to proceed.";
              }
            }

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
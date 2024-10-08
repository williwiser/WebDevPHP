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
            <h1>Sign In</h1>
            <p>Access your account and start sharing recipes</p>
            <?php
            //------------------------------------------------------------------------------------------------------------
//Add database connection here
            
            $servername = "CS3-DEV.ICT.RU.AC.ZA";
            $username = "TheOGs";
            $password = "M7fiB7C6"; // Default password for XAMPP MySQL
            $dbname = "theogs";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            } // <-- Closing brace added here
            
            $userName = $password = "";
            $userNameErr = $passwordErr = "";
            $loginErr = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (empty($_POST["username"])) {
                $userNameErr = "* User name required";
              } else {
                $userName = cleanInput($_POST["username"]);
              }
              if (empty($_POST["password"])) {
                $passwordErr = "* Password required";
              } else {
                $password = cleanInput($_POST["password"]);
              }

              // Proceed only if no validation errors
              if (empty($userNameErr) && empty($passwordErr)) {
                // Prepare and bind to check if the user exists
                $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
                $stmt->bind_param("s", $userName);
                $stmt->execute();
                $stmt->store_result();

                // If user is found
                if ($stmt->num_rows > 0) {
                  // Bind the result variables
                  $stmt->bind_result($userId, $hashedPassword);
                  $stmt->fetch();

                  // Verify the password
                  if (password_verify($password, $hashedPassword)) {
                    // Password is correct - start a session
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_id"] = $userId;
                    $_SESSION["username"] = $userName;

                    // Redirect to a logged-in page or dashboard
                    header("Location: index.php");
                    exit;
                  } else {
                    $loginErr = "Invalid password. Please try again.";
                  }
                } else {
                  $loginErr = "No account found with that username.";
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


            <input placeholder="User Name" type="text" id="username" name="username" />
            <span class="error"><?php echo $userNameErr ?></span>

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
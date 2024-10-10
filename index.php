<?php
session_start();
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
  <!--end navbar-->

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

  <!--Implemented background image to enhance the style-->
  <header>
    <h1>Welcome to <span>Recipe Hub</span></h1>
    <p>Discover, cook, and share delicious recipes with the world!<br /></p>

    <a href="recipes.php" id="explore-btn" title="Explore our collection of recipes"><strong>Explore
        Recipes</strong></a>
  </header>

  <main class="main-content">
    <section id="features">
      <section class="container">
        <h2>Features</h2>
        <article>
          <hgroup class="card">
            <h3>Discover</h3>
            <p>
              Explore a world of flavors and ingredients through our extensive
              collection of recipes. Find inspiration for meals, snacks, and
              desserts from various cuisines and dietary preferences.
            </p>
          </hgroup>

          <hgroup class="card">
            <h3>Cook</h3>
            <p>
              Dive into step-by-step guides and cooking tips that make
              preparing meals easy and enjoyable. Follow simple instructions
              or experiment with advanced techniques to elevate your cooking
              skills.
            </p>
          </hgroup>

          <hgroup class="card">
            <h3>Share</h3>
            <p>
              Exchange tips, tricks, and personal touches that make each dish
              unique. Create memories and inspire fellow home cooks by sharing
              your love for food!
            </p>
          </hgroup>
        </article>
      </section>
    </section>
    <section id="latest-recipes">
      <section class="container">
        <h2>Latest Recipes</h2>
        <hr />
        <p class="description">
          Want to try something new? Get a hold of our newest recipes.
        </p>
        <ul id="latest-recipes-list"></ul>
      </section>
    </section>

    <section id="explore-sn">
      <section class="container">
        <h2>Explore our Recipes</h2>
        <hr />
        <p class="description">
          Check out our diverse catalogue of recipes made by foodies like you.
        </p>
        <ul>
          <li>
            <a href="recipes/chocolate_cake.html" class="explore-link"><span>Vegetarian <br />Cuisines</span></a>
          </li>
          <li>
            <a href="recipes/chocolate_cake.html" class="explore-link">Savory <br />
              Desserts</a>
          </li>
          <li>
            <a href="recipes/chocolate_cake.html" class="explore-link">Italian <br />Delicacies</a>
          </li>
        </ul>
      </section>
    </section>

    <section id="reviews-sn">
      <section class="container">
        <h2>What Others Are Saying</h2>
        <hr />
        <p class="description">
          From cooking tips to favorite recipes, our community shares their
          honest feedback to help you find the perfect dish.
        </p>
        <section class="slide-container">
          <section id="user-reviews" class="slide-container-inner"></section>
        </section>
      </section>
    </section>

    <section id="newsletter">
      <section class="container">
        <h2>Join Our Newsletter</h2>
        <hr />
        <article class="newsletter-content">
          <p>
            By subscribing to our news letter you'll receive exclusive access
            to special recipe collections, cooking tips, and sustainable
            living guide, directly in your inbox. Join the Recipe Hub family
            and elevate your culinary experience.
          </p>

          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "recipe_website_schema";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            $email = "";
            $emailErr = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (empty($_POST["email"])) {
                $emailErr = "* email required";
              } else {
                $email = cleanInput($_POST["email"]);
              }
              $frequency = $_POST["frequency"];

              $stmt = $conn->prepare("SELECT * FROM newsletter WHERE email = ?");
              $stmt->bind_param("s", $email);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO newsletter (email, frequency) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $frequency);

                if ($stmt->execute()) {
                  echo "Subscription successful";
                } else {
                  echo "error: " . $sql . "<br>" . $conn->error;
                }
              } else {
                echo "This email is already on our mailing list.";
              }

              $stmt->close();
            }

            function cleanInput($data)
            {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }
            ?>
            <label for="email">Email: <input type="email" id="email" name="email" /></label>
            <span class="error"><?php echo $emailErr ?></span>
            <label for="frequency">Frequency:
              <select id="frequency" name="frequency">
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
              </select>
            </label>

            <input class="btn" type="submit" value="Subscribe" />
          </form>
        </article>
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
  <script src="script.js"></script>
</body>

</html>
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
        <li class="nav-item">
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="about.html" class="nav-link">About</a>
        </li>
        <li class="nav-item">
          <a href="recipes.php" class="nav-link active">Recipes</a>
        </li>
        <li class="nav-item">
          <a href="contact.php" class="nav-link">Contact</a>
        </li>
        <li class="nav-item">
          <a href="signIn.php" class="nav-link">Sign In</a>
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

    <header>
      <h1>Explore Recipes</h1>
      <p>
        Browse through our extensive collection of recipes shared by food
        enthusiasts like you!
      </p>
    </header>

    <!-- Begin Recipe Dashboard -->
    <section class="recipe-dashboard">
      <div id="recipe-cards" class="recipe-cards"></div>
    </section>
    <!-- End Recipe Dashboard -->

    <footer>
      <section class="container">
        <p>&copy; The OG's 2024. All rights reserved.</p>
        <address role="contentinfo">
          Email: <a href="mailto:recipe@gmail.com">recipe@gmail.com</a><br />
          Phone: <a href="tel:+27451234567">+27 45 123 4567</a>
        </address>
        <!--Begin social buttons-->

        <!--TODO replace links with relevant locations-->
        <div class="social-buttons">
          <a
            href="https://www.instagram.com"
            class="social-button instagram"
            aria-label="Instagram"
            target="_blank"
          ></a>
          <a
            href="https://www.facebook.com"
            class="social-button facebook"
            aria-label="Facebook"
            target="_blank"
          ></a>
          <a
            href="https://www.youtube.com"
            class="social-button youtube"
            aria-label="YouTube"
            target="_blank"
          ></a>
          <a
            href="https://www.github.com"
            class="social-button github"
            aria-label="GitHub"
            target="_blank"
          ></a>
        </div>
        <!--End social buttons-->
      </section>
    </footer>
    <script src="script.js"></script>
    <script src="navigator-info.js"></script>
  </body>
</html>

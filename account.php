<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account | Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body id="my-account">
    <script src="validation.js"></script>
    <script src="navigator-info.js"></script>
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
          <a href="signIn.php" class="nav-link active">Account</a>
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
      <section class="container">
        <h1>My Account</h1>
      </section>
    </header>

    <main>
      <section class="container">
        <article class="prof-info">
          <img class="prof-pic" src="img/avatar-icon.png" />
          <hgroup>
            <h1>ian_smithie</h1>
            <p>james@gmail.com</p>
          </hgroup>
        </article>
        <div class="acc-group">
          <nav>
            <ul>
              <li><a href="#" class="active">Personal Details</a></li>
              <li><a href="#">My Recipes</a></li>
              <li><a href="#">Favorite Recipes</a></li>
              <li><a href="SubmitRecipe.html"> + New Recipe</a></li>
            </ul>
          </nav>

          <section class="info">
            <form class="personal-info-frm card">
              <h1>Personal Details</h1>
              <label for="username">User Name</label>
              <input type="text" value="Ian Smith" />

              <label for="username">Email</label>
              <input type="email" value="james@gmail.com" disabled />
              <input type="submit" value="Save" />
            </form>
          </section>
        </div>
      </section>
    </main>

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
  </body>
</html>

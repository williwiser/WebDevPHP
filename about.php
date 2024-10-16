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
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="about.php" class="nav-link active">About</a>
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
          <a href="signIn.php" class="nav-link">Sign In</a>
        </li>
      <?php } ?>
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

  <header>
    <h1>About us</h1>
    <p>Meet the team and get to know our company</p>
  </header>
  <main id="about">
    <section id="intro">
      <section class="container">
        <img src="img/bowl2.png" />
        <hgroup>
          <h1>Who we are</h1>
          <p>
            We are a dynamic team composed of three skilled software
            engineers, each bringing a unique set of expertise and creativity
            to the table. With a shared passion for coding and
            problem-solving, we specialize in building innovative,
            user-friendly applications. As a tight-knit team, The OG's are
            committed to delivering high-quality digital solutions that drive
            success in today's competitive online landscape.
          </p>
        </hgroup>
      </section>
    </section>

    <section id="intro-2">
      <section class="container">
        <hgroup>
          <h1>What we do</h1>
          <p>
            At our team, we're passionate about more than just coding—we're
            also food lovers who understand the joy of discovering and sharing
            delicious recipes. Our expertise shines through in our
            recipe-sharing app, where we've meticulously crafted a platform
            designed to celebrate the art of cooking.
          </p>
        </hgroup>
        <img src="img/plate.png" />
      </section>
    </section>
    <section id="team">
      <section class="container">
        <h1>Meet the team</h1>
        <section class="members">
          <article class="card">
            <img src="img/jaco.jpg" alt="Jaco" />
            <hgroup>
              <h1>Jacobus Van Sandwyk</h1>
              <p>Full-Stack Developer</p>
            </hgroup>
            <p>
              Meet Jacobus, a versatile programmer during the weekdays,
              dangerous hunter on the weekends.
            </p>
          </article>

          <article class="card">
            <img src="img/kai.jpg" alt="Kai" />
            <hgroup>
              <h1>Kaizer Makhubo</h1>
              <p>Full-Stack Developer</p>
            </hgroup>
            <p>
              Meet Kaizer, a talented developer who occasionally ponders the
              mysteries of the universe.
            </p>
          </article>

          <article class="card">
            <img src="img/will.jpg" alt="Willy" />
            <hgroup>
              <h1>William Wani</h1>
              <p>Front-End Developer</p>
            </hgroup>
            <p>
              Meet William, a seasoned developer and surprisingly, a talented
              musician.
            </p>
          </article>
        </section>
      </section>
    </section>
  </main>
  <!--main content sections here-->
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
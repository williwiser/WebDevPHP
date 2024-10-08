<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact | Recipes</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
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
        <a href="contact.php" class="nav-link active">Contact</a>
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
    <h1>Contact Us</h1>
    <p>
      If you have any questions or feedback, feel free to reach out to us!
    </p>
  </header>

  <main>
    <section id="contact-sn">
      <section class="container">
        <form action="submit_contact.html" method="post">
          <h2>Get in Touch</h2>
          <label>Name:
            <input type="text" id="name" name="name" required />
          </label>

          <label for="email">Email:
            <input type="email" id="email" name="email" required />
          </label>

          <label for="message">Message:
            <textarea id="message" name="message" rows="4" cols="50"></textarea>
          </label>

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
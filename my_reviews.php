<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<?php
$servername = "CS3-DEV.ICT.RU.AC.ZA";
$username = "TheOGs";
$password = "M7fiB7C6";
$dbname = "theogs";
$conn = new mysqli($servername, $username, $password, $dbname);
$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$username = $stmt->get_result();

$stmt = $conn->prepare("SELECT email FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$email = $stmt->get_result();
$feedback = "";
$response = "";
$name = "";
?>

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
                    <a href="account.php" class="nav-link active">My Account</a>
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
                <div class="prof-cont">
                    <img class="prof-pic" src="img/avatar-icon.png" />
                    <hgroup>
                        <h1><?php while ($row = $username->fetch_assoc()) {
                            $name = $row['username'];
                            echo $row['username'];
                        } ?></h1>
                        <p><?php while ($row = $email->fetch_assoc()) {
                            echo $row['email'];
                        } ?></p>
                    </hgroup>
                </div>
                <form id="logout" action='log_out.php' method="POST">
                    <input type="submit" id="logout" value="Log out">
                </form>
            </article>
            <div class="acc-group">
                <nav>
                    <ul>
                        <li><a href="account.php">Personal Details</a></li>
                        <li><a href="my_reviews.php" class="active">My Reviews</a></li>
                        <li><a href="newsletter.php">Newsletter</a></li>
                        <li><a href="delete_account.php">Delete Account</a></li>
                    </ul>
                </nav>

                <section class="info">
                    <form class="personal-info-frm" method="POST">
                        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $feedback = $_POST["feedback"];
                            $stmt = $conn->prepare("INSERT INTO reviews (user_id, feedback) VALUES (?, ?)");
                            $stmt->bind_param("ss", $user_id, $feedback);
                            if ($stmt->execute()) {
                                $response = "Thanks for the feedback!";
                            } else {
                                $response = "Sorry, something went wrong.";
                            }
                        } ?>
                        <h1>Reviews</h1>
                        <label for="username">Feedback</label>
                        <textarea name="feedback" placeholder="What do you think of our site?"></textarea>
                        <input type="submit" value="Submit" />
                        <?php echo $response; ?>
                    </form>
                </section>
            </div>
        </section>
    </main>

    <footer>
        <section class="container">
            <p>&copy; The OG's 2024. All rights reserved.</p>
            <!--Begin social buttons-->

            <!--TODO replace links with relevant locations-->
            <div class="social-buttons">
                <a href="https://www.instagram.com" class="social-button instagram" aria-label="Instagram"
                    target="_blank"></a>
                <a href="https://www.facebook.com" class="social-button facebook" aria-label="Facebook"
                    target="_blank"></a>
                <a href="https://www.youtube.com" class="social-button youtube" aria-label="YouTube"
                    target="_blank"></a>
                <a href="https://www.github.com" class="social-button github" aria-label="GitHub" target="_blank"></a>
            </div>
            <!--End social buttons-->
        </section>
    </footer>
</body>

</html>
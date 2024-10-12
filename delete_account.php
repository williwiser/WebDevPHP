<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to a custom 404 page or show an error message
    header("Location: 404.php");
    exit(); // Stop the script from executing further
}
ob_start();
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

$stmt->close();

$name = "";
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account | Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body id="my-account">
    <script src="validation.js"></script>
    <script src="navigator-info.js"></script>
    <script src="script.js"></script>
    <script>
        let mod = document.getElementById("showModal");

        mod.addEventListener("click", showMod());
        function showMod() {
            deleteModal.style.display = "flex";
            alert("hi");
        }
    </script>
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
                    <a href="account.php" class="nav-link active">My Account <i class="fa fa-user"></i></a>
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
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["logout"])) {
                        // remove all session variables
                        session_unset();
                        // destroy the session
                        session_destroy();
                        header("Location: index.php");
                        exit();
                    }
                } ?>
                <form id="logout" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="submit" name="logout" id="logout" value="Log out">
                </form>
            </article>
            <div class="acc-group">
                <nav>
                    <ul>
                        <li><a href="account.php">Personal Details</a></li>
                        <li><a href="my_reviews.php">My Reviews</a></li>
                        <li><a href="delete_acc.php" class="active">Delete Account</a></li>
                    </ul>
                </nav>

                <section class="info">

                    <div id="delete_modal">
                        <form class="no-hover-card" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
                            method="POST">
                            <h1>Delete Account</h1>
                            <p>Are you sure? This action cannot be reversed.</p>
                            <div class="btns">
                                <input type="submit" name="delete" value="Delete">
                                <button value="Back" class="back-btn"
                                    onclick=" let deleteModal = document.getElementById('delete_modal');  deleteModal.style.display = 'none';">Back</button>
                            </div>

                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST["delete"])) {
                                    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $stmt->close();
                                    // Remove all session variables
                                    session_unset();

                                    // Destroy the session
                                    session_destroy();

                                    // Redirect to index.php with a confirmation
                                    header("Location: index.php?deletedacc=true");
                                    exit(); // Ensure the script stops executing after redirection
                            

                                }
                            }
                            ?>
                        </form>
                    </div>
                    <div class="personal-info-frm">
                        <h1>Delete My Account</h1>
                        <p>This action is irreversible.</p>
                        <button id="showModal"
                            onclick=" let deleteModal = document.getElementById('delete_modal');  deleteModal.style.display = 'flex';">Delete
                            Account</button>
                    </div>
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
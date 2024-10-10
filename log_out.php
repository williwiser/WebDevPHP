<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    header("Location: index.php");
    exit;
}
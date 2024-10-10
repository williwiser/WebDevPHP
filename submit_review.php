<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST["feedback"];

    // Prepare and bind
    $addReview = $conn->prepare("INSERT INTO reviews (user_id, feedback) VALUES (?, ?)");
    $addReview->bind_param("ss", $user_id, $feedback);

    if ($addReview->execute()) {
        $response = "Thanks for your feedback!";
    } else {
        $response = "Sorry something went wrong.";
    }
}
?>
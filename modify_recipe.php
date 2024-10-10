<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'], $input['title'], $input['description'], $input['ingredients'], $input['instructions'])) {
        $recipeId = $input['id'];
        $title = $input['title'];
        $description = $input['description'];
        $ingredients = $input['ingredients'];
        $instructions = $input['instructions'];

        $conn = new mysqli('localhost', 'root', '', 'recipe_website_schema');
        if ($conn->connect_error) {
            http_response_code(500);
            exit('Database connection error.');
        }

        $stmt = $conn->prepare("UPDATE recipes SET title = ?, description = ? WHERE recipe_id = ?");
        $stmt->bind_param("ssi", $title, $description, $recipeId);
        if ($stmt->execute()) {
            $conn->query("DELETE FROM ingredients WHERE recipe_id = $recipeId");
            foreach ($ingredients as $ingredient) {
                $stmt = $conn->prepare("INSERT INTO ingredients (recipe_id, ingredient) VALUES (?, ?)");
                $stmt->bind_param("is", $recipeId, $ingredient);
                $stmt->execute();
            }

            $conn->query("DELETE FROM instructions WHERE recipe_id = $recipeId");
            foreach ($instructions as $index => $instruction) {
                $stepNumber = $index + 1;
                $stmt = $conn->prepare("INSERT INTO instructions (recipe_id, step_number, instruction) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $recipeId, $stepNumber, $instruction);
                $stmt->execute();
            }

            http_response_code(200);
            echo 'Recipe updated successfully';
        } else {
            http_response_code(500);
            echo 'Error updating recipe';
        }

        $stmt->close();
        $conn->close();
    } else {
        http_response_code(400);
        echo 'Invalid input';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?>

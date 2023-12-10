<?php
// check_email.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $emailToCheck = $_POST['email'];

    // Perform the check in your database
    $conn = new mysqli('localhost', 'root', '', 'plat');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $checkEmailQuery = "SELECT * FROM car WHERE email = ?";
    $stmtCheck = $conn->prepare($checkEmailQuery);

    if ($stmtCheck) {
        $stmtCheck->bind_param("s", $emailToCheck);
        $stmtCheck->execute();

        $result = $stmtCheck->get_result();
        if ($result->num_rows > 0) {
            echo 'exists';
        } else {
            echo 'not_exists';
        }

        $stmtCheck->close();
        $conn->close();
    } else {
        echo 'error';
        $conn->close();
    }
} else {
    echo 'invalid_request';
}
?>

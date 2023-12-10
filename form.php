<?php
// Check if the form is submitted
// Assuming the user input is valid, store nom and prenom in the session
session_start();

$_SESSION['nom'] = $_POST['nom'];
$_SESSION['prenom'] = $_POST['prenom'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['countries'] = $_POST['countries'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $country = $_POST['countries'];
    $dateN = $_POST['dateN']; // Assuming dateN is coming from the form
    $sexe = $_POST['sexe'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'plat');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM car WHERE email = ?";
    $stmtCheck = $conn->prepare($checkEmailQuery);
    
    if ($stmtCheck) {
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        
        $result = $stmtCheck->get_result();
        if ($result->num_rows > 0) {
            // Email already exists, show an alert
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
            $stmtCheck->close();
            $conn->close();
            echo "<script>window.location.href='account.html';</script>"; // Redirect back to the account.html page
            exit; // Stop further execution
        }
        
        $stmtCheck->close();
    } else {
        echo "Error: " . $conn->error;
        $conn->close();
        exit; // Stop further execution
    }

    // Assuming your 'dateN' column in the database is of type DATE
    $dateN = date("Y-m-d", strtotime($dateN)); 

    // Insert new record
    $stmt = $conn->prepare("INSERT INTO car (nom, prenom, email, pwd, country, dateN, sexe) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Check if the prepare statement is successful
    if ($stmt) {
        $stmt->bind_param("sssssss", $nom, $prenom, $email, $pwd, $country, $dateN, $sexe);
        $execval = $stmt->execute();
        if ($execval) {
            header("Location: profile.php");
            exit; // Stop further execution
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
    
    $conn->close();
}
?>

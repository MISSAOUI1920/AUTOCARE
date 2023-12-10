<?php
session_start(); // Start the session

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $login = $_POST['username'];
    $pwd = $_POST['password'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'plat');

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour récupérer le mot de passe associé au login
    $stmt = $conn->prepare("SELECT country, nom, prenom, email, pwd FROM car WHERE email = ?");
    
    // Vérifier si la préparation de la requête est réussie
    if ($stmt) {
        $stmt->bind_param("s", $login);

        // Exécuter la requête
        $stmt->execute();

        // Récupérer le résultat
        $stmt->bind_result($country, $nom, $prenom, $email, $hashed_password);
        $stmt->fetch();

        if ($pwd == $hashed_password) {
            // Authentication successful, store user information in session
            $_SESSION['countries'] = $country;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['email'] = $email;   
            $_SESSION['notification'] = 'Authentication successful.';
            echo '<script>
                    setTimeout(function() {
                        alert("' . $_SESSION['notification'] . '");
                        window.location.href = "profile.php";
                    }, 100);
                  </script>';
        } else {
            $_SESSION['notification'] = 'Authentication not valid.\nIncorrect email or password!';
            echo '<script>
                    setTimeout(function() {
                        alert("' . $_SESSION['notification'] . '");
                        window.location.href = "log.html";
                    }, 100);
                  </script>';
        }
        
        $stmt->close();
    } else {
        echo "Erreur: " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

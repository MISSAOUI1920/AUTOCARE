<?php
session_start(); // Start the session

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pwd = $_POST['pwd'];
    $dateN = $_POST['dateN']; // Assuming dateN is coming from the form

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'plat');

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Vérifier si les champs ne sont pas vides avant la mise à jour
    if (!empty($nom) || !empty($prenom) || !empty($pwd) || !empty($dateN)) {
        
        $stmt = $conn->prepare("UPDATE car SET nom=?, prenom=?, pwd=?, dateN=? WHERE email=?");
        
        // Vérifier si la préparation de la requête est réussie
        if ($stmt) {
            $stmt->bind_param("sssss", $nom, $prenom, $pwd, $dateN, $_SESSION['email']);

            // Exécuter la requête
            $execval = $stmt->execute();

            if ($execval) {
                $_SESSION['notification'] = 'Informations modifiées avec succès.';
                echo '<script>
                        setTimeout(function() {
                            alert("' . $_SESSION['notification'] . '");
                            window.location.href = "profile.php";
                        }, 100);
                      </script>';
            } else {
                echo "Erreur lors de la mise à jour : " . $stmt->error;
            }
            
            
            $stmt->close();
        } else {
            echo "Erreur: " . $conn->error;
        }
    } else {
        // Les champs sont vides, aucune mise à jour nécessaire
        $_SESSION['notification'] = 'Aucune modification effectuée.';
        echo '<script>
                setTimeout(function() {
                    alert("' . $_SESSION['notification'] . '");
                    window.location.href = "profile.php";
                }, 100);
              </script>';
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<?php

// Chemin vers votre fichier CSV
$chemin_fichier_csv = 'C:\xampp\htdocs\webproject\cars.csv';

// Charger les données du CSV
$donnees = array_map('str_getcsv', file($chemin_fichier_csv));

// Extraire les en-têtes (première ligne)
$entetes = array_shift($donnees);

// Créer un tableau associatif pour chaque ligne
$voitures = array();
foreach ($donnees as $ligne) {
    $voitures[] = array_combine($entetes, $ligne);
}

// Fonction pour filtrer les voitures en fonction des critères de recherche
function filtrerVoitures($voitures, $marque, $modele, $cat) {
    $resultats = array();

    foreach ($voitures as $voiture) {
        if (
            // Check all the criteria
            ($marque == '' || strtolower($voiture['Manufacturer']) == strtolower($marque)) &&
            ($modele == '' || strtolower($voiture['Model']) == strtolower($modele)) &&
            ($cat == '' || strtolower($voiture['Category']) == strtolower($cat))
        ) {
            $resultats[] = $voiture;
        }
    }

    return $resultats;
}

// Traiter la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque1 = isset($_POST['manufacturer1']) ? $_POST['manufacturer1'] : '';
    $modele1 = isset($_POST['modelDropdown1']) ? $_POST['modelDropdown1'] : '';
    $cat1 = isset($_POST['category1']) ? $_POST['category1'] : '';
    $marque2 = isset($_POST['manufacturer2']) ? $_POST['manufacturer2'] : '';
    $modele2 = isset($_POST['modelDropdown2']) ? $_POST['modelDropdown2'] : '';
    $cat2 = isset($_POST['category2']) ? $_POST['category2'] : '';
    // Filtrer les voitures en fonction des critères de recherche
    $resultats1 = filtrerVoitures($voitures, $marque1, $modele1, $cat1);
    $resultats2 = filtrerVoitures($voitures, $marque2, $modele2, $cat2);

   
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer and Model Dropdowns</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #444;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1px 0; /* Adjust padding as needed */
        }

        nav {
            background-color: #444;
            color: #fff;
            text-align: center;
            padding: 1em 0;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            padding: 5px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover, nav a.active {
            background-color: #3498db;
        }

        .comparsection {
            text-align: center; /* Center the content horizontally */
            color: #333;
        }

        .box1, .box2 {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out;
            display: inline-block; /* Added to align boxes horizontally */
            margin: 20px; /* Added margin between boxes */
        }

        select {
            width: 100%; /* Set the width to 100% of the parent container */
            padding: 8px; /* Adjust padding as needed */
            margin-bottom: 16px; /* Adjust margin as needed */
            box-sizing: border-box;
        }
        

        form {
    height: auto; /* Change height to auto to accommodate content */
    max-width: 700px; /* Set a maximum width for better responsiveness */
    margin: 0 auto; /* Center the form horizontally */
    background-color: rgba(255, 255, 255, 0.13);
    color: #fff;
    text-align: center;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    padding: 30px 35px;
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
}


        section {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }
        .feature {
        font-weight: bold;
        margin-right: 5px;
        padding: 8px;
        text-align: left;
        border-radius: 5px;
        border: 2px solid blue;
        background-color: #f2f2f2;
        display: inline-flexbox;
        margin-bottom: 5px;
    }

    </style>
</head>
<body>

    <header>
        <a href="homepage.html">
            <img src="photo/logo.png" alt="ValuRide Logo" class="logo">
        </a>    
        <nav>
            <a href="homepage.html">Accueil</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Comparaison de Voitures</h2>
        <section class="comparsection">
            <div class="box1">
                <h3>First car</h3>
                <select name="manufacturer1" id="manufacturer1" required>
                <option value="">Select Model</option>
                </select><br>

                <select name="modelDropdown1" id="modelDropdown1" required>
                <option value="">Select Model</option>
                </select><br>
                
                <select name="category1" id="category1" required>
                <option value="">Select Model</option>
                </select><br>
            </div>

            <div class="box2">
                <h3>Second car</h3>

                <!-- Manufacturer Dropdown -->
                <select name="manufacturer2" id="manufacturer2" required>
                <option value="">Select Model</option>
                </select><br>

                <!-- Model Dropdown -->
                <select name="modelDropdown2" id="modelDropdown2" required>
                <option value="">Select Model</option>
                </select><br>
                
                <select name="category2" id="category2" required>
                <option value="">Select Model</option>
                </select><br>
            </div>
        </section>
        <section>
            <button type="submit">Comparer</button>
            <button type="reset">Reset</button>
        </section>
    </form>
    <section>
    <div class="box1" id="result-container1">
        <?php
function displayResults($results) {
    if (isset($results)) {
        if (empty($results)) {
            echo "<p>Aucun résultat trouvé.</p>";
        } else {

            foreach ($results as $ligne) {
                echo "<div class='result-row'>";
                foreach ($ligne as $cle => $valeur) {
                        echo "<div class='feature'>$cle: $valeur</div>";

                    
                }
                echo "</div>"; // Close result-row
            }

            echo "</div>"; // Close result-box
        }
    }
}


if (isset($resultats1)) {
    displayResults($resultats1);
} else {
    echo "<p>Aucun résultat trouvé.</p>";
}
?>    
    </div>

    <div class="box2" id="result-container2">
        <?php
        
        if (isset($resultats2)) {
            displayResults($resultats2);
        } else {
            echo "<p>Aucun résultat trouvé.</p>";
        }
        ?>
        
    </div>
    
    </section>
    <script>
        fetch('load.php')
            .then(response => response.json())
            .then(data => {
                // Get the select elements for box1
                var manufacturerSelect1 = document.getElementById("manufacturer1");
                var modelSelect1 = document.getElementById("modelDropdown1");
                var categorySelect1 = document.getElementById("category1");

                // Populate the manufacturer dropdown for box1
                for (var i = 0; i < data.manufacturers.length; i++) {
                    var option = document.createElement("option");
                    option.text = data.manufacturers[i];
                    manufacturerSelect1.add(option);
                }

                // Populate the model dropdown for box1
                for (var j = 0; j < data.models.length; j++) {
                    var option = document.createElement("option");
                    option.text = data.models[j];
                    modelSelect1.add(option);
                }

                // Populate the category dropdown for box1
                for (var k = 0; k < data.categories.length; k++) {
                    var option = document.createElement("option");
                    option.text = data.categories[k];
                    categorySelect1.add(option);
                }

                // Get the select elements for box2
                var manufacturerSelect2 = document.getElementById("manufacturer2");
                var modelSelect2 = document.getElementById("modelDropdown2");
                var categorySelect2 = document.getElementById("category2");

                // Populate the manufacturer dropdown for box2
                for (var l = 0; l < data.manufacturers.length; l++) {
                    var option = document.createElement("option");
                    option.text = data.manufacturers[l];
                    manufacturerSelect2.add(option);
                }

                // Populate the model dropdown for box2
                for (var m = 0; m < data.models.length; m++) {
                    var option = document.createElement("option");
                    option.text = data.models[m];
                    modelSelect2.add(option);
                }

                // Populate the category dropdown for box2
                for (var n = 0; n < data.categories.length; n++) {
                    var option = document.createElement("option");
                    option.text = data.categories[n];
                    categorySelect2.add(option);
                }
            })
            
            .catch(error => console.error('Error fetching data:', error));
    </script>
    


</body>
</html>

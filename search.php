<?php
$conn = new mysqli('localhost', 'root', '', 'plat');
    
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Chemin vers votre fichier CSV
$chemin_fichier_csv = 'C:\xampp\htdocs\webproject\car.csv';

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
function filtrerVoitures($voitures, $marque, $prixMax, $modele, $cat, $leat, $fuel, $vol, $mile, $cyl, $gea, $dr, $wh, $col, $air, $age, $levy) {
    $resultats = array();

    foreach ($voitures as $voiture) {
        if (
            // Check all the criteria
            ($marque == '' || strtolower($voiture['Manufacturer']) == strtolower($marque)) &&
            ($prixMax == '' || $voiture['Price'] <= $prixMax) &&
            ($modele == '' || strtolower($voiture['Model']) == strtolower($modele)) &&
            ($cat == '' || strtolower($voiture['Category']) == strtolower($cat)) &&
            ($leat == '' || strtolower($voiture['Leather interior']) == strtolower($leat)) &&
            ($fuel == '' || strtolower($voiture['Fuel type']) == strtolower($fuel)) &&
            ($vol == '' || $voiture['Engine volume'] == $vol) &&
            ($mile == '' || $voiture['Mileage'] <= $mile) &&
            ($cyl == '' || $voiture['Cylinders'] == $cyl) &&
            ($gea == '' || strtolower($voiture['Gear box type']) == strtolower($gea)) &&
            ($dr == '' || strtolower($voiture['Drive wheels']) == strtolower($dr)) &&
            ($wh == '' || strtolower($voiture['Wheel']) == strtolower($wh)) &&
            ($col == '' || strtolower($voiture['Color']) == strtolower($col)) &&
            ($air == '' || $voiture['Airbags'] == $air) &&
            ($age == '' || $voiture['Age'] == $age) &&
            ($levy == '' || $voiture['Levy'] == $levy)
            
        ) {
                       $resultats[] = $voiture;
        }
    }

    return $resultats;
}

// ...

// Traiter la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque = isset($_POST['marque']) ? $_POST['marque'] : '';
    $prixMax = isset($_POST['prixMax']) ? $_POST['prixMax'] : '';
    $modele = isset($_POST['modele']) ? $_POST['modele'] : ''; // Fix the typo here
    $cat = isset($_POST['cat']) ? $_POST['cat'] : '';
    $leat = isset($_POST['leat']) ? $_POST['leat'] : '';
    $fuel = isset($_POST['fuel']) ? $_POST['fuel'] : '';
    $vol = isset($_POST['vol']) ? $_POST['vol'] : '';
    $mile = isset($_POST['mile']) ? $_POST['mile'] : '';
    $cyl = isset($_POST['cyl']) ? $_POST['cyl'] : '';
    $gea = isset($_POST['gea']) ? $_POST['gea'] : '';
    $dr = isset($_POST['dr']) ? $_POST['dr'] : '';
    $wh = isset($_POST['wh']) ? $_POST['wh'] : '';
    $col = isset($_POST['col']) ? $_POST['col'] : '';
    $air = isset($_POST['air']) ? $_POST['air'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $levy = isset($_POST['levy']) ? $_POST['levy'] : ''; // Fix the missing closing parenthesis
    // Filtrer les voitures en fonction des critères de recherche
    $conn->query("INSERT INTO items (manufacturer, modele, fuel_type, leather_interior, engine_volume, color, wheel, gear_box_type, drive_wheels, category, price, levy, mileage, cylinders, airbags, age)
              VALUES ('$marque', '$modele', '$fuel', '$leat', '$vol', '$col', '$wh', '$gea', '$dr', '$cat', '$prixMax', '$levy', '$mile', '$cyl', '$air', '$age')");

    $resultats = filtrerVoitures($voitures, $marque, $prixMax, $modele, $cat, $leat, $fuel, $vol, $mile, $cyl, $gea, $dr, $wh, $col, $air, $age, $levy);
}

// ...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Voitures</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

h2,p {
    text-align: center;
    color: #555;
}
header {
  background-color: #333;
  color: #fff;
  text-align: center;
  padding: 3px;
  width: 100%;
}

form {
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
}

select, input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #4caf50;
    color: #fff;
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
  padding: 10px 15px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

nav a:hover {
  background-color: #3498db;
}

nav a.active {
  background-color: #3498db;
}

</style>

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
    <h2>Recherche de Voitures</h2>
<script>
    fetch('load.php')
        .then(response => response.json())
        .then(data => {
            // Get the select elements
            var manufacturerSelect = document.getElementById("marque");
            var modelSelect = document.getElementById("modele");
            var categorySelect=document.getElementById("cat");
            // Populate the manufacturer dropdown
            for (var i = 0; i < data.manufacturers.length; i++) {
                var option = document.createElement("option");
                option.text = data.manufacturers[i];
                manufacturerSelect.add(option);
            }

            // Populate the model dropdown
            for (var j = 0; j < data.models.length; j++) {
                var option = document.createElement("option");
                option.text = data.models[j];
                modelSelect.add(option);
            }
            for (var i = 0; i < data.categories.length; i++) {
                var option = document.createElement("option");
                option.text = data.categories[i];
               categorySelect.add(option);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
</script>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<label for="marque">Manufacturer:</label>
<select id="marque" name="marque">
<option value="">Select Marque</option>

    
</select>


        <!-- Replace the input field for "Model" with a select field -->
<label for="modele">Model:</label>
<select id="modele" name="modele">
    <option value="">Select Model</option>
    
</select>


        <!-- Replace the input field for "Fuel Type" with a select field -->
<label for="fuel">Fuel Type:</label>
<select id="fuel" name="fuel">
    <option value="">Select Fuel Type</option>
    <option value="Hybrid">Hybrid</option>
    <option value="Petrol">Petrol</option>
    <option value="Diesel">Diesel</option>
    <option value="CNG">CNG</option>
    <option value="Plug-in Hybrid">Plug-in Hybrid</option>
    <option value="LPG">LPG</option>
    <option value="Hydrogen">Hydrogen</option>
</select>


        <label for="leat">Leather interior :</label>
        <select id="leat" name="leat">
        <option value="">Select option</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="vol">Engine volume :</label>
        <input type="text" name="vol" id="vol">
        
        <!-- Replace the input field for "Color" with a select field -->
<label for="col">Color:</label>
<select id="col" name="col">
    <option value="">Select Color</option>
    <option value="Silver">Silver</option>
    <option value="Black">Black</option>
    <option value="White">White</option>
    <option value="Grey">Grey</option>
    <option value="Blue">Blue</option>
    <option value="Green">Green</option>
    <option value="Red">Red</option>
    <option value="Sky blue">Sky blue</option>
    <option value="Orange">Orange</option>
    <option value="Yellow">Yellow</option>
    <option value="Brown">Brown</option>
    <option value="Golden">Golden</option>
    <option value="Beige">Beige</option>
    <option value="Carnelian red">Carnelian red</option>
    <option value="Purple">Purple</option>
    <option value="Pink">Pink</option>
</select>


        <!-- Replace the input field for "Wheel" with a select field -->
<label for="wh">Wheel:</label>
<select id="wh" name="wh">
    <option value="">Select Wheel</option>
    <option value="Left wheel">Left wheel</option>
    <option value="Right-hand drive">Right-hand drive</option>
</select>


        <!-- Replace the input field for "Gear Box Type" with a select field -->
<label for="gea">Gear Box Type:</label>
<select id="gea" name="gea">
    <option value="">Select Gear Box Type</option>
    <option value="Automatic">Automatic</option>
    <option value="Tiptronic">Tiptronic</option>
    <option value="Variator">Variator</option>
    <option value="Manual">Manual</option>
</select>


        <!-- Replace the input field for "Drive Wheels" with a select field -->
<label for="dr">Drive Wheels:</label>
<select id="dr" name="dr">
    <option value="">Select Drive Wheels</option>
    <option value="4x4">4x4</option>
    <option value="Front">Front</option>
    <option value="Rear">Rear</option>
</select>



        <!-- Replace the input field for "Category" with a select field -->
<label for="cat">Category:</label>
<select id="cat" name="cat">
<option value="">Select Category</option>

</select>


        <label for="prixMax">Prix maximum :</label>
        <input type="text" name="prixMax" id="prixMax">

        <label for="levy">Levy :</label>
        <input type="text" name="levy" id="levy">

        <label for="mile">Mileage :</label>
        <input type="text" name="mile" id="mile">

        <label for="cyl">Cylinders :</label>
        <input type="text" name="cyl" id="cyl">

        <label for="air">Airbags :</label>
        <input type="text" name="air" id="air">

    
        <label for="age">Age :</label>
        <input type="text" name="age" id="age">
        
        <button type="submit">Rechercher</button>
        <button type="reset">Reset</button>
    </form>

    <?php
    if (isset($resultats)) {
        if (empty($resultats)) {
            echo "<p>Aucun résultat trouvé.</p>";
        } else {
            echo "<h3>Résultats de la recherche :</h3>";
            echo "<table border='1'>";
            echo "<tr>";
            foreach ($entetes as $entete) {
                echo "<th>$entete</th>";
            }
            echo "</tr>";

            foreach ($resultats as $ligne) {
                echo '<tr>';
                foreach ($ligne as $valeur) {
                    echo "<td>$valeur</td>";
                }
                echo '</tr>';
            }
            echo "</table>";
        }
    }
    ?>

</body>
</html>


<?php
// Start the session
session_start();

// Check if nom and prenom are set in the session
if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])&&isset($_SESSION['email'])&&isset($_SESSION['countries'])) {
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email= $_SESSION['email'];
    $country= $_SESSION['countries'];
} else {
    // If not set, you might want to handle this case (redirect to login, show an error, etc.)
    header("Location: homepage.html");
    exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/pro.js"></script>
    <title>Accueil</title>
    <style>

main {
    display: flex;
    flex: 1;
    padding: 20px;
}

sidebar {
    width: 350px;
    background-color: #444;
    padding: 20px;
    border-right: 1px solid #34495e;;
}

sidebar h3 {
    color: #fff;
    margin-bottom: 15px;
    font-size: 1.2em;
}

sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

sidebar li {
    margin-bottom: 10px;
}

sidebar a {
    color: #fff;
    text-decoration: none;
    font-size: 1em;
    transition: color 0.3s ease;
}

sidebar a:hover {
    color: #ffcc00;
}
li{
    color: #ecf0f1;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

article {
    display: inline-block;
    margin: 20px;
}

.dashboard-box,
.search-box,
.prediction-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.dashboard-box img,
.search-box img,
.prediction-box img {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
}

.dashboard-box p,
.search-box p,
.prediction-box p {
    color: black;
}

.dashboard-box:hover,
.search-box:hover,
.prediction-box:hover {
    transform: scale(1.05);
}

.profile-image {
width: 100px;
height: 100px;
border-radius: 50%; /* Pour créer une image de profil circulaire */
margin-bottom: 10px;
cursor: pointer;
}

/* Style pour masquer le champ de téléchargement de fichiers */
#profile-image-input {
display: none;
}

    </style>
</head>


<body>
    <header>
       
            <a href="homepage.html">
                <img src="photo/logo.png" alt="ValuRide Logo" class="logo">
            </a>    
        <nav>
            <a href="homepage.html">Home</a>
         
            <a href="modify.html">Modify Account</a>
       
            <a href="logout.php">Log Out</a>
        </nav>
    </header>

    <main>
        <!-- Sidebar -->
        <sidebar>
            <label for="profile-image-input">
                <img src="photo/pro.jpg" alt="Image de Profil" class="profile-image" id="preview-image"><br>
            </label>
            <input type="file" id="profile-image-input" accept="image/*" style="display: none;">        
            <ul>
                <li><?php echo 'Name: '. $nom; ?></li>
                <li><?php echo 'First Name: '. $prenom; ?></li>
                <li><?php echo 'Email: '. $email; ?></li>
                <li><?php echo 'Country: '. $country; ?></li>
            </ul>
        </sidebar>
        

        <article class="dashboard-section">
    <a href="serchdash.php">
        <div class="dashboard-box">
            <img src="photo/dash.png" alt="Dashboard Icon">
            <h3>Dashboard</h3>
            <p>Explore comprehensive statistics and insights about your platform usage, user activity, and system performance.</p>
        </div>
    </a>
</article>

<article class="search-section">
    <a href="search.php">
        <div class="search-box">
            <img src="photo/search.png" alt="Search Icon">
            <h3>Search</h3>
            <p>Effortlessly find the information you need with our powerful and intuitive search functionality.</p>
        </div>
    </a>
</article>

<article class="prediction-section">
    <a href="tes.php">
        <div class="prediction-box">
            <img src="photo/price.png" alt="Prediction Icon">
            <h3>Prediction</h3>
            <p>Get insights into future trends and outcomes based on historical data and advanced predictive analytics.</p>
        </div>
    </a>
</article>

<article class="prediction-section">
    <a href="compar.php">
        <div class="prediction-box">
            <img src="photo/cars.png" alt="Prediction Icon">
            <h3>Comparaison</h3>
            <p>Get insights into future trends and outcomes based on historical data and advanced predictive analytics.</p>
        </div>
    </a>
</article>
    </main>

    <footer>
        <p>&copy; 2023 Le Monde Des Voitures. Tous droits réservés.</p>
    </footer>

</body>

</html>

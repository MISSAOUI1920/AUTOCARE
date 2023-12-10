<?php
// Your existing code for database insertion here...
$conn = new mysqli('localhost', 'root', '', 'plat');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
// Retrieve data for visualization
$result = $conn->query("SELECT sexe, country, YEAR(CURDATE()) - YEAR(dateN) as age FROM car");
$data = array('sexes' => array('homme' => 0, 'femme' => 0), 'ageCategories' => array(),'countries' => array());

while ($row = $result->fetch_assoc()) {

    // Count sexes
    $data['sexes'][$row['sexe']]++;

    // Categorize age
    $age = $row['age'];
    $ageCategory = floor($age / 10) * 10 . '-' . (floor($age / 10) + 1) * 10;
    if (!isset($data['ageCategories'][$ageCategory])) {
        $data['ageCategories'][$ageCategory] = 0;
    }
    $data['ageCategories'][$ageCategory]++;
    // Collect data for country distribution
    $country = $row['country'];
    if (!isset($data['countries'][$country])) {
        $data['countries'][$country] = 0;
    }
    $data['countries'][$country]++;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Statistics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    h2,h1{
        text-align: center;
    }
    .sexd,.aged,.countryd{
        text-align: center;

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
.chart-container {
            display: flex;
            justify-content: space-around; /* Adjust as needed */
            margin-top: 20px; /* Add some margin for spacing */
        }
</style>
</head>

<body>

    <h1>Dashboard De Statistiques Générales</h1>
    <nav>
            <a href="homepage.html">Accueil</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Log Out</a>
        </nav>

        <h2>Statistiques Générales sur les Utilisateurs du plateforme</h2>
        <div class="chart-container">
    <div class="sexd" style="width: 20%;">
        <h4>SEX CHART </h4>       
    <canvas id="sexChart"></canvas>
    </div>
    <div class="countryd" style="width: 20%; height: 300px;">
        <h4>Country Distribution</h4>
        <canvas id="countryChart"></canvas>
    </div>

    <div class="aged" style="width: 40%;">
        <h4>Age Distribution</h4>
        <canvas id="ageChart"></canvas>
    </div>
        </div>
        
   

    <script>
        var sexData = <?php echo json_encode($data['sexes']); ?>;
        var ageData = <?php echo json_encode($data['ageCategories']); ?>;
        var countryData = <?php echo json_encode($data['countries']); ?>;

        var sexChartCanvas = document.getElementById('sexChart').getContext('2d');
        var sexChart = new Chart(sexChartCanvas, {
            type: 'pie',
            data: {
                labels: Object.keys(sexData),
                datasets: [{
                    data: Object.values(sexData),
                    backgroundColor: ['#3498db', '#e74c3c'],
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Sex Distribution',
                },
            }
        });

        var ageChartCanvas = document.getElementById('ageChart').getContext('2d');
        var ageChart = new Chart(ageChartCanvas, {
            type: 'bar',
            data: {
                labels: Object.keys(ageData),
                datasets: [{
                    label: 'Number of Users',
                    data: Object.values(ageData),
                    backgroundColor: '#2ecc71',
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Age Distribution',
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });

        var countryChartCanvas = document.getElementById('countryChart').getContext('2d');

// Function to generate a random color
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

var backgroundColors = Object.keys(countryData).map(function() {
    return getRandomColor();
});

var countryChart = new Chart(countryChartCanvas, {
    type: 'pie',
    data: {
        labels: Object.keys(countryData),
        datasets: [{
            data: Object.values(countryData),
            backgroundColor: backgroundColors,
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Country Distribution',
        },
        responsive: true,
        maintainAspectRatio: false,
    }
});

    </script><br>
    <h2>La Distribution des Recherches Faites:</h2><br>
    <?php
    // Include the content of t.php
    include('serchdash.php');
    ?>
</body>
</html>

<?php
// Your PHP code to fetch data from the database (similar to what you did in the search)
$conn = new mysqli('localhost', 'root', '', 'plat');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the 'items' table
$result = $conn->query("SELECT manufacturer as Manufacturer, modele as Model, fuel_type as Type_Of_Fuel, leather_interior as Leather_Interior, color as Color, wheel as Wheel, gear_box_type as Type_Of_Gear_Box, drive_wheels as Drive_Wheels, category as Category, cylinders as Cylinders, airbags as Airbags, age as Age FROM items");

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Fetch data as an associative array
$data = $result->fetch_all(MYSQLI_ASSOC);

// Get column names
$columns = array_keys($data[0]);

// Close the result set
$result->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>
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

        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            margin-bottom: 20px;
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

        <h2>Statistiques Générales sur les Recherches les Plus Fréquents</h2>
    <table border="1">
        <?php
        // Loop through each column
        $count = 0;
        foreach ($columns as $column) {
            // Filter non-empty values for the current column
            $nonEmptyValues = array_filter(array_column($data, $column), function ($value) {
                return $value !== '';
            });

            // Count occurrences of each non-empty value
            $columnData = array_count_values($nonEmptyValues);

            // Generate a unique chart ID based on the column name
            $chartId = $column . 'Chart';

            // If it's the first chart in the row, create a new row
            if ($count % 3 == 0) {
                echo "<tr>";
            }

            echo "<td>";
            echo "<h4>".$column."</h4>";
            echo "<canvas id=\"$chartId\" width=\"480\" height=\"500\"></canvas>";
            
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var <?php echo $column; ?>Data = <?php echo json_encode($columnData); ?>;
                    var <?php echo $column; ?>Ctx = document.getElementById('<?php echo $chartId; ?>').getContext('2d');

                    new Chart(<?php echo $column; ?>Ctx, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(<?php echo $column; ?>Data),
                            datasets: [{
                                data: Object.values(<?php echo $column; ?>Data),
                                backgroundColor: getRandomColors(Object.values(<?php echo $column; ?>Data).length),
                                borderColor: 'rgba(0, 0, 0, 1)',
                                borderWidth: 1
                            }]
                        },
                        
                                
                    });
                });

                function getRandomColors(numColors) {
                    var letters = '0123456789ABCDEF';
                    var colors = [];
                    for (var j = 0; j < numColors; j++) {
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        colors.push(color);
                    }
                    return colors;
                }
            </script>
            <?php
            echo "</td>";

            // If it's the last chart in the row, close the row
            if (($count + 1) % 3 == 0) {
                echo "</tr>";
            }

            $count++;
        }
        ?>
    </table>
</body>
</html>

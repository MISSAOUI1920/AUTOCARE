<?php
// Le code PHP pour lire le fichier CSV et renvoyer les fabricants
$file = fopen('car.csv', 'r');
$manufacturers = [];
while (($line = fgetcsv($file)) !== FALSE) {
    $manufacturers[] = $line[3]; // Colonne des fabricants
}
fclose($file);

// Supprimer les doublons
$manufacturers = array_unique($manufacturers);

// Convertir en JSON et imprimer
$manufacturers_json = json_encode(array_values($manufacturers));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Dropdown</title>
</head>
<body>

<!-- Your HTML code -->
<select id="manufacturerDropdown">
    <!-- Options will be added dynamically using JavaScript -->
</select>

<script>
    // Parse JSON data
    var manufacturers = <?php echo $manufacturers_json; ?>;

    // Get the select element
    var select = document.getElementById("manufacturerDropdown");

    // Populate the select element with options
    for (var i = 0; i < manufacturers.length; i++) {
        var option = document.createElement("option");
        option.text = manufacturers[i];
        select.add(option);
    }
</script>

</body>
</html>

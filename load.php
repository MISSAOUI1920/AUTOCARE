<?php
// Le code PHP pour lire le fichier CSV et renvoyer les fabricants
$file = fopen('car.csv', 'r');
$manufacturers = [];
$models = [];
$category= [];
fgetcsv($file);
while (($line = fgetcsv($file)) !== FALSE) {
    $category[]= $line[5];
    $fueltype[] = $line[7]; 
    $manufacturers[] = $line[3]; // Colonne des fabricants
    $models[] = $line[4]; // Colonne des modèles
}

fclose($file);

// Supprimer les doublons
$manufacturers = array_values(array_unique($manufacturers));
$models = array_values(array_unique($models));
$fueltypes=array_values(array_unique($fueltype));
$categories=array_values(array_unique($category));
// Convertir en JSON et imprimer
echo json_encode(array('manufacturers' => $manufacturers, 'models' => $models,'categories'=>$categories,'fueltypes'=> $fueltypes));
?>

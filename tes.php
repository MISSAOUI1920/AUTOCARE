<?php

$command = "streamlit run web.py 2>&1";
$output = exec($command, $outputArray, $returnValue);

if ($returnValue !== 0) {
    // Handle error
    echo "Error: " . implode("\n", $outputArray);
} else {
    echo "Success: " . implode("\n", $outputArray);
}

?>

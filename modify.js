document.getElementById("modifyForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Get input values
    var newName = document.getElementById("newName").value;
    // Get more input values as needed

    // Send the data to the server for processing
    fetch("modify-data.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "newName=" + encodeURIComponent(newName) // Include other data as needed
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
        console.log(data);
        alert("Data modified successfully!"); // You can customize this message
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error modifying data. Please try again."); // You can customize this message
    });
});

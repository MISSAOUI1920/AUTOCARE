window.onload = function () {
    // Get the file input and preview image elements
    var fileInput = document.getElementById('profile-image-input');
    var previewImage = document.getElementById('preview-image');

    // Add an event listener to the file input
    fileInput.addEventListener('change', function () {
        // Check if a file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            // Set up the reader to read the selected file
            reader.onload = function (e) {
                // Update the source of the preview image with the selected file's data
                previewImage.src = e.target.result;
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(fileInput.files[0]);
        }
    });
};
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('registrationForm');
    var pwd = document.getElementById('pwd');
    var cpwd = document.getElementById('cpwd');
    var errorsMsg = document.getElementById('errors-msg');
    var errorMsg = document.getElementById('error-msg');
    var successMsg = document.getElementById('succ-msg');

    function checkPassword() {
        var password = pwd.value;
        var confirmPassword = cpwd.value;

        // Check if the password meets the criteria
        var hasUpperCase = /[A-Z]/.test(password);
        var hasDigit = /\d/.test(password);
        var isLengthValid = password.length >= 10;

        // Display error message based on the criteria
        if (!hasUpperCase || !hasDigit || !isLengthValid) {
            errorMsg.textContent = 'The password must contain at least 10 characters, one uppercase letter and one number.';
            successMsg.textContent = '';
            return false;
        } else {
            errorMsg.textContent = '';
        }

        // Check if the passwords match
        if (password !== confirmPassword) {
            errorMsg.textContent = 'Passwords do not match.';
            successMsg.textContent = '';
            return false;
        } else {
            successMsg.textContent = 'Passwords are compatible';
            return true;
        }
    }

    function onSubmit(event) {
        // If any condition is not met, prevent form submission and show alert
        if (!checkPassword()) {
            event.preventDefault(); // Prevent form submission
            alert('Veuillez vérifier le mot de passe.');
        }
    }

    // Attach the checkPassword function to the 'input' event of both password fields
    pwd.addEventListener('input', checkPassword);
    cpwd.addEventListener('input', checkPassword);

    // Attach the onSubmit function to the 'submit' event of the form
    form.addEventListener('submit', onSubmit);
});

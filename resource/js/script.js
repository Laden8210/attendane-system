const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
const toggleIcon = document.querySelector('#toggleIcon');

togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    toggleIcon.classList.toggle('fa-eye');
    toggleIcon.classList.toggle('fa-eye-slash');
});
$(document).ready(function() {
    $('#add-student-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'controller/add-student.php',
            type: 'POST',
            data: { test: 'testData' }, // Send simple test data
            success: function(response) {
                console.log('AJAX Success:', response);
                alert('AJAX call was successful!');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('AJAX call failed!');
            }
        });
    });
});
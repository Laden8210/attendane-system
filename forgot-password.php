<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
</head>

<body class="bg-violet-900 bg-cover bg-center min-h-screen flex flex-col relative">
  <!-- Full-Screen Loader -->
  <div id="loader" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="w-16 h-16 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
  </div>

  <!-- Header Section -->


  <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6 sm:p-8">
      <form id="reset-password-form" action="../controllers/request_reset_password.php" method="POST" onsubmit="return handleResetPassword();">
        <h1 class="text-3xl font-bold text-center font-mono tracking-widest mb-6">Forgot Password</h1>
        <p class="text-sm text-justify font-poppins mb-6">
          Enter your email address below, and we’ll send you a link to reset your password.
        </p>

        <!-- Email Input -->
        <div class="relative w-full mb-6">
          <input
            type="email"
            id="email"
            name="email"
            aria-label="Email"
            class="font-poppins block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-0 focus:border-[#003C68] peer"
            placeholder=""
            required />
          <label
            for="email"
            class="font-poppins absolute text-gray-500 text-sm top-2 left-2 px-1 bg-white transition-all transform scale-100 translate-y-0 peer-placeholder-shown:translate-y-2.5 peer-placeholder-shown:scale-100 peer-focus:translate-y-0 peer-focus:scale-75">
            Email
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-[#4CB4FF] text-white text-lg font-bold font-poppins py-2 rounded-3xl transition-transform duration-300 transform hover:scale-105 hover:bg-[#003C68]">
          Submit
        </button>

        <!-- Back to Login -->
        <div class="text-center mt-6">
          <a href="index.php?view=login" class="font-poppins text-sm underline text-[#003C68] hover:text-[#001F34]">
            Back to Login
          </a>
        </div>
      </form>


    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const loader = document.getElementById('loader');

    function showLoader() {
      loader.classList.remove('hidden');
      setTimeout(() => {
        loader.style.opacity = '1';
      }, 10); // Trigger fade-in
    }

    function hideLoader() {
      loader.style.opacity = '0';
      setTimeout(() => {
        loader.classList.add('hidden');
      }, 300); // Match fade-out duration
    }

    function handleResetPassword() {
      const email = document.getElementById('email').value;

      Swal.fire({
        title: 'Confirm Reset Request',
        text: `We will send a password reset link to: ${email}. Do you want to proceed?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4CB4FF',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, send it!'
      }).then((result) => {
        if (result.isConfirmed) {
          showLoader(); // Show loader

          fetch('request_reset_password.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email })
          })
          .then(response => response.json())
          .then(data => {
            hideLoader(); // Hide loader

            if (data.status === 'success') {
              Swal.fire({
                title: 'Request Processed',
                text: 'A password reset link has been sent to your email.',
                icon: 'success',
                confirmButtonColor: '#4CB4FF'
              });
            } else {
              Swal.fire({
                title: 'Error',
                text: data.message || 'An error occurred. Please try again.',
                icon: 'error',
                confirmButtonColor: '#d33'
              });
            }
          })
          .catch(error => {
            hideLoader(); // Hide loader
            console.error('Error:', error);
            Swal.fire({
              title: 'Unexpected Error',
              text: 'An unexpected error occurred. Please try again.',
              icon: 'error',
              confirmButtonColor: '#d33'
            });
          });
        }
      });

      return false; 
    }
  </script>
</body>

</html>

<section class="w-screen h-screen bg-violet-900">
    <div class="flex items-center justify-center h-full">
        <!-- Card Container -->
        <div class="w-full max-w-2xl bg-white rounded-lg p-10 shadow-lg">
            <!-- Title Section -->
            <div class="text-center mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-violet-900">
                    Web-based School Event Attendance Monitoring System Login
                </h1>
            </div>
            <!-- Login Form Section -->
            <form id="loginForm">
                <div class="space-y-5">
                    <!-- Username Field -->
                    <div class="flex items-center">
                        <label for="username" class="mr-4 text-violet-900">
                            <i class="fas fa-user"></i>
                        </label>
                        <input type="text" name="username" id="username"
                            class="w-full p-2 outline-none rounded border border-gray-300"
                            placeholder="Email or Username" required>
                    </div>
                    <!-- Password Field -->
                    <div class="flex items-center relative">
                        <label for="password" class="mr-4 text-violet-900">
                            <i class="fas fa-unlock-alt"></i>
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full p-2 outline-none rounded border border-gray-300"
                            placeholder="Password" required>
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 px-3 text-gray-500">
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('login-process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Redirect based on user type
                    if (data.user_type_id == 0) {
                        window.location.href = 'super-admin/';
                    } else if (data.user_type_id == 1) {
                        window.location.href = 'admin/';
                    } else if (data.user_type_id == 2) {
                        window.location.href = 'student/';
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
});


    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        toggleIcon.classList.toggle("fa-eye");
        toggleIcon.classList.toggle("fa-eye-slash");
    });
</script>
<section class="w-screen h-screen">
    <div class="w-screen h-screen flex justify-center bg-violet-900">
        <div class="w-2/3 flex justify-center p-10">
            <div class="grid grid-cols-2">
                <div>
                    <div class="text-start">
                        <h1 class="text-4xl font-bold text-white">Web-based School Event Attendance Monitoring System Login</h1>
                    </div>
                </div>
                <div>
                    <form id="loginForm">
                        <div class="">
                            <div class="grid grid-cols-3 items-center mb-5">
                                <div class="text-end me-4">
                                    <label for="username" class="text-white"><i class="fas fa-user"></i></label>
                                </div>
                                <div class="col-span-2">
                                    <input type="text" name="username" id="username" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Email or Username" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 items-center mb-5">
                                <div class="text-end me-4">
                                    <label for="password" class="text-white"><i class="fas fa-unlock-alt"></i></label>
                                </div>
                                <div class="col-span-2 relative">
                                    <input type="password" name="password" id="password" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Password" required>
                                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-gray-500">
                                        <i id="toggleIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="grid grid-rows-2 gap-5">
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                        if (data.user_type_id == 0) {
                            window.location.href = 'super-admin/';
                        } else if (data.user_type_id == 1) {
                            window.location.href = 'admin';
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

    // Toggle password visibility
    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        toggleIcon.classList.toggle("fa-eye");
        toggleIcon.classList.toggle("fa-eye-slash");
    });
</script>
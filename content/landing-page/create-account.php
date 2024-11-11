<?php


?>

<section class="w-screen h-screen">
    <div class="w-screen h-screen flex items-center justify-center bg-gradient-to-r from-violet-500 to-indigo-500">
        <div class="bg-white shadow-lg rounded-lg w-full md:w-1/2 lg:w-1/3 p-6">
            <h1 class="text-center text-3xl font-bold text-gray-800 mb-6">Create Admin Account</h1>
            <p class="text-center text-gray-600 mb-6">Fill in the details below to create a new administrator account.</p>
            <hr class="h-1 bg-cyan-500 mb-6">

            <form id="createAccountForm" enctype="multipart/form-data">
                <div class="space-y-4">
                    <div>
                        <label for="first_name" class="block text-gray-700 font-medium">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" placeholder="Enter first name" required>
                    </div>

                    <div>
                        <label for="last_name" class="block text-gray-700 font-medium">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" placeholder="Enter last name" required>
                    </div>

                    <div>
                        <label for="middle_name" class="block text-gray-700 font-medium">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" placeholder="Enter middle name">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 font-medium">Email</label>
                        <input type="email" name="email" id="email" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" placeholder="Enter email address" required>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 font-medium">Password</label>
                        <input type="password" name="password" id="password" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" placeholder="Enter password" required>
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-gray-700 font-medium">Re-enter Password</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" placeholder="Re-enter password" required>
                    </div>

                    <div>
                        <label for="avatar" class="block text-gray-700 font-medium">Upload Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:ring focus:ring-indigo-200">Create Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
document.getElementById('createAccountForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('create-account.php', {
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
                window.location.href = 'dashboard.php';
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
</script>

<?php


?>

<section class="w-screen h-screen">
    <div class="w-screen h-screen flex items-center justify-center bg-gradient-to-r from-violet-500 to-indigo-500">
        <div class="bg-white shadow-md rounded-md w-full max-w-md p-6">
            <h1 class="text-center text-2xl font-semibold text-gray-800 mb-4">Create Admin Account</h1>
            <p class="text-center text-gray-500 text-sm mb-4">Fill in the details to register a new admin.</p>
            <hr class="h-1 bg-indigo-400 mb-4 rounded">

            <form id="createAccountForm" enctype="multipart/form-data" class="space-y-3">
                <div>
                    <label for="first_name" class="block text-gray-700 text-sm font-medium mb-1">First Name</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" 
                        placeholder="First Name" 
                        required>
                </div>

                <div>
                    <label for="last_name" class="block text-gray-700 text-sm font-medium mb-1">Last Name</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" 
                        placeholder="Last Name" 
                        required>
                </div>

                <div>
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" 
                        placeholder="Email Address" 
                        required>
                </div>

                <div>
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" 
                        placeholder="Password" 
                        required>
                </div>

                <div>
                    <label for="password_confirm" class="block text-gray-700 text-sm font-medium mb-1">Re-enter Password</label>
                    <input 
                        type="password" 
                        name="password_confirm" 
                        id="password_confirm" 
                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500" 
                        placeholder="Confirm Password" 
                        required>
                </div>

                <div>
                    <label for="avatar" class="block text-gray-700 text-sm font-medium mb-1">Avatar (Optional)</label>
                    <input 
                        type="file" 
                        name="avatar" 
                        id="avatar" 
                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                </div>

                <div class="flex justify-end mt-4">
                    <button type="reset" class="bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded hover:bg-gray-300 mr-2">Reset</button>
                    <button type="submit" class="bg-indigo-500 text-white text-sm px-4 py-2 rounded hover:bg-indigo-600 focus:ring focus:ring-indigo-300">Create</button>
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
                window.location.href = 'super-admin/index.php?view=dashboard';
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

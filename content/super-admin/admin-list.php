<section class=" bg-violet-600  overflow-auto">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full rounded-lg overflow-x-hidden overflow-y-auto">
            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Admin List</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded">
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button data-modal-target="add-student-modal" data-modal-toggle="add-student-modal"
                            class="shadow rounded bg-blue-500 px-2 py-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                    </div>
                    <div class="flex justify-end gap-2 items-center">
                        <label for="search" class="text-black">Search</label>
                        <input id="search" name="search" type="search" placeholder="Search by name or email"
                            class="text-black outline-none border border-slate-700 px-2 py-1" oninput="searchUsers()" />
                    </div>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">#</th>
                                <th scope="col" class="px-2 py-3">Last Name</th>
                                <th scope="col" class="px-2 py-3">First Name</th>
                                <th scope="col" class="px-2 py-3">Middle Name</th>
                                <th scope="col" class="px-2 py-3">Email</th>
                                <th scope="col" class="px-2 py-3">Department</th>
                                <th scope="col" class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Admin list will be populated here by searchUsers() -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main modal -->
<div id="add-student-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Add Admin Account</h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="add-student-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" id="add-user-form">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Select Department</label>
                        <select name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Department</option>
                            <!-- Dynamically populate departments -->
                            <?php
                            $courses = $courseRepository->getAllCourses();
                            foreach ($courses as $course) {
                                echo "<option value='" . $course['ID'] . "'>"  . $course['COURSE_NAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Select User Type</label>
                        <select name="user_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="1">Admin</option>

                        </select>
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                        <input type="text" name="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                        <input type="text" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Middle Name</label>
                        <input type="text" name="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Avatar</label>
                        <input type="file" name="avatar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Admin Modal -->
<div id="edit-admin-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Edit Admin Account</h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="edit-admin-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" id="edit-user-form">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Select Department</label>
                        <select name="course" id="edit-course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Department</option>
                            <!-- Dynamically populate departments -->
                            <?php
                            $courses = $courseRepository->getAllCourses();
                            foreach ($courses as $course) {
                                echo "<option value='" . $course['ID'] . "'>" . $course['COURSE_NAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                        <input type="text" name="first_name" id="edit-first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                        <input type="text" name="last_name" id="edit-last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Middle Name</label>
                        <input type="text" name="middle_name" id="edit-middle-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="edit-email" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', (event) => {
            const modalId = button.getAttribute('data-modal-hide');
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                modalElement.classList.add('hidden');
                window.location.reload();
            }
        });
    });

    async function searchUsers() {
        const searchValue = document.getElementById('search').value;

        const response = await fetch('controller/search-users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                search: searchValue
            })
        });

        const data = await response.json();

        const tbody = document.querySelector('tbody');
        tbody.innerHTML = ''; // Clear existing table rows

        if (data.status === 'success') {
            data.users.forEach(user => {
                const row = `
                <tr class="bg-white border-b text-xs text-center">
                    <td class="px-2 py-3">${user.user_id}</td>
                    <td class="px-2 py-3">${user.last_name}</td>
                    <td class="px-2 py-3">${user.first_name}</td>
                    <td class="px-2 py-3">${user.middle_name}</td>
                    <td class="px-2 py-3">${user.email}</td>
                    <td class="px-2 py-3">${user.COURSE_NAME}</td>
                    <td class="px-6 py-3">
                        <button class="text-xs rounded-full bg-red-600 hover:bg-red-500 px-2 py-1 text-white"
                            onclick="deleteUser(${user.user_id})">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        <button class="text-xs rounded-full bg-blue-600 hover:bg-blue-500 px-2 py-1 text-white"
                            onclick="editUser(${user.user_id})">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            const row = `
            <tr class="bg-white border-b text-xs text-center">
                <td colspan="7" class="px-2 py-3">No results found</td>
            </tr>
        `;
            tbody.insertAdjacentHTML('beforeend', row);
        }
    }

    searchUsers();

    const addStudentForm = document.getElementById('add-user-form');
    addStudentForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(addStudentForm);

        const response = await fetch('controller/add-user.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                confirmButtonText: 'OK'
            }).then(() => {
                addStudentForm.reset();
                document.querySelector('[data-modal-hide="add-student-modal"]').click();
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'An error occurred. Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });
    async function editUser(userId) {
        try {
            // Fetch user data
            const response = await fetch(`controller/edit-user.php?user_id=${userId}`);
            if (!response.ok) {
                throw new Error(`Failed to fetch user data: ${response.statusText}`);
            }
            const user = await response.json();

            const modalElement = document.getElementById('edit-admin-modal');
            const modal = new Modal(modalElement);
            modal.show();
            document.querySelector('#edit-first-name').value = user.first_name || '';
            document.querySelector('#edit-last-name').value = user.last_name || '';
            document.querySelector('#edit-middle-name').value = user.middle_name || '';
            document.querySelector('#edit-email').value = user.email || '';
            document.querySelector('#edit-course').value = user.course_id || '';


            const updateForm = document.getElementById('edit-user-form');
            updateForm.onsubmit = async (e) => {
                e.preventDefault();
                try {
                    const formData = new FormData(updateForm);
                    formData.append('user_id', userId);

                    const updateResponse = await fetch('controller/update-user.php', {
                        method: 'POST',
                        body: formData,
                    });

                    const updateData = await updateResponse.json();

                    if (updateData.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'User updated successfully',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            updateForm.reset();
                            location.reload();
                        });
                    } else {
                        throw new Error(updateData.message || 'Failed to update user');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'An error occurred while updating the user',
                        confirmButtonText: 'OK',
                    });
                }
            };
        } catch (error) {
            console.error('Error:', error.message);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to load user data',
                confirmButtonText: 'OK',
            });
        }
    }

    async function deleteUser(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await fetch('controller/delete-user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload(); // Refresh the page to update the user list
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to delete user.',
                        'error'
                    );
                }
            }
        });
    }
</script>
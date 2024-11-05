<section class=" bg-violet-600 h-screen overflow-auto">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full h-screen rounded-lg overflow-x-hidden overflow-y-auto">
            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Officer Account</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded">
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button data-modal-target="add-officer-modal" data-modal-toggle="add-officer-modal" class="shadow rounded bg-blue-500 px-2 py-1">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </button>
                    </div>
                    <div class="flex justify-end gap-2 items-center">
                        <label for="search" class="text-black">Search</label>
                        <input name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-2 py-1" />
                    </div>
                </div>
                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">#</th>
                                <th scope="col" class="px-2 py-3">Avatar</th>
                                <th scope="col" class="px-2 py-3">Last Name</th>
                                <th scope="col" class="px-2 py-3">First Name</th>
                                <th scope="col" class="px-2 py-3">Course</th>
                                <th scope="col" class="px-2 py-3">Username</th>
                                <th scope="col" class="px-2 py-3">Password</th>
                                <th scope="col" class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic content will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Officer Modal -->
<div id="add-officer-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Add Officer Account</h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="add-officer-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form id="add-officer-form">
                    <div>
                        <label for="student-select" class="block mb-2 text-sm font-medium text-gray-900">Select Student</label>
                        <select name="student_id" id="student-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></select>
                    </div>
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add Officer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Officer Modal -->
<div id="edit-officer-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Edit Officer Account</h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="edit-officer-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form id="edit-officer-form">
                    <input type="hidden" name="officer_id" id="edit-officer-id" />
                    <div>
                        <label for="edit-student-select" class="block mb-2 text-sm font-medium text-gray-900">Select Student</label>
                        <select name="student_id" id="edit-student-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></select>
                    </div>
                    <div>
                        <label for="edit-username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <input type="text" name="username" id="edit-username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="edit-password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="edit-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update Officer</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flowbite modals
    const addOfficerModalElement = document.getElementById('add-officer-modal');
    const editOfficerModalElement = document.getElementById('edit-officer-modal');
    
    const addOfficerModal = new Modal(addOfficerModalElement); // Modal for adding officers
    const editOfficerModal = new Modal(editOfficerModalElement); // Modal for editing officers

    // Fetch and display all officers
    async function fetchOfficers() {
        const response = await fetch('controller/officer-controller.php?action=list');
        const data = await response.json();
        const tbody = document.querySelector('tbody');
        tbody.innerHTML = ''; // Clear existing rows

        if (data.officers.length > 0) {
            data.officers.forEach((officer, index) => {
                const avatarSrc = officer.AVATAR ? `data:image/jpeg;base64,${officer.AVATAR}` : 'https://via.placeholder.com/150'; // Fallback image
          
                const row = `
                <tr class="bg-white border-b text-xs text-center">
                    <td class="px-2 py-3">${index + 1}</td>
                    <td class="px-2 py-3">
                        <img class="w-20 h-20 object-cover" src="${avatarSrc}" alt="gallery-image" />
                    </td>
                    <td class="px-2 py-3">${officer.LAST_NAME}</td>
                    <td class="px-2 py-3">${officer.FIRST_NAME}</td>
                    <td class="px-2 py-3">${officer.COURSE}</td>
                    <td class="px-2 py-3">${officer.USERNAME}</td>
                    <td class="px-2 py-3">******</td>
                    <td class="px-6 py-3">
                        <button class="text-xs rounded-full bg-red-600 hover:bg-red-500 px-2 py-1 text-white" onclick="deleteOfficer(${officer.OFFICER_ID})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        <button class="text-xs rounded-full bg-blue-600 hover:bg-blue-500 px-2 py-1 text-white" onclick="editOfficer(${officer.OFFICER_ID})"><i class="fa fa-edit" aria-hidden="true"></i></button>
                    </td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="11" class="text-center text-sm">No officers found.</td></tr>';
        }
    }

    // Function to delete an officer
    async function deleteOfficer(officerId) {
        const confirmation = await Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        });

        if (confirmation.isConfirmed) {
            const response = await fetch(`controller/officer-controller.php?action=delete&officer_id=${officerId}`, {
                method: 'POST'
            });
            const result = await response.json();
            if (result.success) {
                Swal.fire('Deleted!', 'Officer has been deleted.', 'success');
                fetchOfficers(); // Refresh the list after deletion
            } else {
                Swal.fire('Error!', 'Failed to delete officer.', 'error');
            }
        }
    }

    // Function to populate the student dropdown
    async function populateStudentDropdown() {
        const response = await fetch('controller/student-controller.php?action=list');
        const data = await response.json();
        const studentDropdown = document.querySelector('#student-select');

        const editStudentDropdown= document.querySelector('#edit-student-select');
        data.students.forEach(student => {
            const option = document.createElement('option');
            option.value = student.STUDENT_ID;
            option.text = `${student.FIRST_NAME} ${student.LAST_NAME}`;
            studentDropdown.add(option);

            
        });

        data.students.forEach(student => {
            const option = document.createElement('option');
            option.value = student.STUDENT_ID;
            option.text = `${student.FIRST_NAME} ${student.LAST_NAME}`;

            editStudentDropdown.add(option)
            
        });
    }

    // Add Officer form submission with Swal
    const addOfficerForm = document.querySelector('#add-officer-form');
    addOfficerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(addOfficerForm);

        const response = await fetch('controller/officer-controller.php?action=create', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            Swal.fire('Success!', 'Officer added successfully!', 'success');
            addOfficerForm.reset();
            document.querySelector('[data-modal-hide="add-officer-modal"]').click(); // Close modal
            fetchOfficers(); // Refresh the list
        } else {
            Swal.fire('Error!', 'Failed to add officer.', 'error');
        }
    });

    // Edit Officer
    async function editOfficer(officerId) {
        const response = await fetch(`controller/officer-controller.php?action=edit&officer_id=${officerId}`);
        const officer = await response.json();

        if (officer) {
            document.querySelector('#edit-officer-id').value = officer.OFFICER_ID;
            document.querySelector('#edit-student-select').value = officer.STUDENT_ID;
            document.querySelector('#edit-username').value = officer.USERNAME;

            editOfficerModal.show(); // Open modal for editing
        }
    }

    // Update Officer form submission with Swal
    const editOfficerForm = document.querySelector('#edit-officer-form');
    editOfficerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(editOfficerForm);

        const response = await fetch('controller/officer-controller.php?action=update', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            Swal.fire('Success!', 'Officer updated successfully!', 'success');
            document.querySelector('[data-modal-hide="edit-officer-modal"]').click(); // Close modal
            fetchOfficers(); // Refresh the list
        } else {
            Swal.fire('Error!', 'Failed to update officer.', 'error');
        }
    });

    // Load data when the page is ready
    fetchOfficers();
    populateStudentDropdown();

    // Expose functions to the global scope
    window.deleteOfficer = deleteOfficer;
    window.editOfficer = editOfficer;
});

</script>
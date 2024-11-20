<style>
   


</style>
<section class="bg-violet-600 min-h-screen flex ">
    <div class="container mx-auto px-6 py-10">
        <!-- Dashboard Container -->
        <div class="bg-white w-full rounded-lg shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-cyan-500 text-white py-6 px-6">
                <h1 class="text-3xl font-bold text-center">Dashboard</h1>
            </div>
            <hr class="border-t-4 border-cyan-400">

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 p-6">
                <!-- Card: Total Admins -->
                <div class="bg-blue-600 text-white rounded-lg shadow p-6 flex flex-col items-start hover:shadow-lg transform transition hover:scale-105">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-user-friends text-4xl"></i>
                        <h2 class="text-xl font-semibold ml-4">Total Admin</h2>
                    </div>
                    <p id="total-admins" class="text-4xl font-bold self-end">0</p>
                </div>

                <!-- Card: Total Courses -->
                <div class="bg-green-600 text-white rounded-lg shadow p-6 flex flex-col items-start hover:shadow-lg transform transition hover:scale-105">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-book text-4xl"></i>
                        <h2 class="text-xl font-semibold ml-4">Total Courses</h2>
                    </div>
                    <p id="total-courses" class="text-4xl font-bold self-end">0</p>
                </div>
            </div>



            <!-- Tables Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 max-h-72">
                <!-- Admins Table -->
                <div class="bg-gray-50 rounded-lg shadow p-6 overflow-auto max-h-50">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Admins</h2>
                    <table class="table-auto w-full text-sm text-left text-gray-700 border-collapse rounded-lg overflow-hidden">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-xs text-center">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Admin Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Course Handle</th>
                            </tr>
                        </thead>
                        <tbody id="admin-table-body" class="bg-white">
                            <!-- Admins will be dynamically injected here -->
                        </tbody>
                    </table>
                </div>

                <!-- Courses Table -->
                <div class="bg-gray-50 rounded-lg shadow p-6 overflow-auto">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Courses</h2>
                    <table class="table-auto w-full text-sm text-left text-gray-700 border-collapse rounded-lg overflow-hidden">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-xs text-center">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Course</th>
                                <th class="px-4 py-2">Description</th>
                            </tr>
                        </thead>
                        <tbody id="course-table-body" class="bg-white">
                            <!-- Courses will be dynamically injected here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Fetch total counts
    fetch('controller/get_dashboard_counts.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-admins').textContent = data.totalAdmins;
            document.getElementById('total-courses').textContent = data.totalCourses;
        })
        .catch(error => console.error('Error fetching dashboard counts:', error));

    // Fetch admins and courses
    fetch('controller/get_admins_courses.php')
        .then(response => response.json())
        .then(data => {
            const adminTableBody = document.getElementById('admin-table-body');
            const courseTableBody = document.getElementById('course-table-body');

            adminTableBody.innerHTML = '';
            courseTableBody.innerHTML = '';

            // Populate admins table
            data.admins.forEach((admin, index) => {
                const row = `
                <tr class="border-b text-center hover:bg-gray-100">
                    <td class="px-4 py-2">${index + 1}</td>
                    <td class="px-4 py-2">${admin.first_name} ${admin.last_name}</td>
                    <td class="px-4 py-2">${admin.email}</td>
                     <td class="px-4 py-2">${admin.COURSE_NAME ? admin.COURSE_NAME : 'No Course Handled'}</td>
                </tr>
                `;
                adminTableBody.insertAdjacentHTML('beforeend', row);
            });

            // Populate courses table
            data.courses.forEach((course, index) => {
                const row = `
                <tr class="border-b text-center hover:bg-gray-100">
                    <td class="px-4 py-2">${index + 1}</td>
                    <td class="px-4 py-2">${course.COURSE_NAME}</td>
                    <td class="px-4 py-2">${course.DESCRIPTION}</td>
                </tr>
                `;
                courseTableBody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(error => console.error('Error fetching admins and courses:', error));

        
</script>

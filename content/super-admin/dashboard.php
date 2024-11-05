<section class=" bg-violet-600">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full rounded-lg overflow-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <hr class="h-2 bg-cyan-500">
            </div>

            <div class="grid grid-cols-2 gap-5 m-2">

                <div class="rounded shadow p-2">
                    <div class="flex justify-between items-center p-2">
                        <div>
                            <i class="fas fa-user-friends text-6xl "></i>
                            <h1 class="text-2xl">Total Admin</h1>
                        </div>

                        <div>
                            <h1 id="total-admins" class="text-8xl font-bold font-mono">0</h1>
                        </div>
                    </div>
                </div>
                <div class="rounded shadow p-2">
                    <div class="flex justify-between items-center p-2">
                        <div>
                            <i class="fas fa-book text-6xl "></i>
                            <h1 class="text-2xl">Total Courses</h1>
                        </div>

                        <div>
                            <h1 id="total-courses" class="text-8xl font-bold font-mono">0</h1>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-2 m-2">
                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">#</th>
                                <th scope="col" class="px-2 py-3">Admin Name</th>
                                <th scope="col" class="px-2 py-3">Email</th>
                                <th scope="col" class="px-2 py-3">Course Handle</th>
                            </tr>
                        </thead>
                        <tbody id="admin-table-body">
                            <!-- Admins will be injected here -->
                        </tbody>
                    </table>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">#</th>
                                <th scope="col" class="px-2 py-3">Course Code</th>
                                <th scope="col" class="px-2 py-3">Course Description</th>
                            </tr>
                        </thead>
                        <tbody id="course-table-body">
                            <!-- Courses will be injected here -->
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</section>


<script>
    fetch('controller/get_dashboard_counts.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-admins').textContent = data.totalAdmins;
            document.getElementById('total-courses').textContent = data.totalCourses;
        })
        .catch(error => console.error('Error fetching dashboard counts:', error));


    fetch('controller/get_admins_courses.php')
        .then(response => response.json())
        .then(data => {
            const adminTableBody = document.getElementById('admin-table-body');
            const courseTableBody = document.getElementById('course-table-body');


            adminTableBody.innerHTML = '';
            courseTableBody.innerHTML = '';


            data.admins.forEach((admin, index) => {
                const row = `
                <tr class="bg-white border-b text-xs text-center">
                    <td class="px-2 py-3">${index + 1}</td>
                    <td class="px-2 py-3">${admin.first_name} ${admin.last_name}</td>
                    <td class="px-2 py-3">${admin.email}</td>
                    <td class="px-2 py-3">${admin.course_handle}</td>
                </tr>
            `;
                adminTableBody.insertAdjacentHTML('beforeend', row);
            });

            // Populate course table
            data.courses.forEach((course, index) => {
                const row = `
                <tr class="bg-white border-b text-xs text-center">
                    <td class="px-2 py-3">${index + 1}</td>
                    <td class="px-2 py-3">${course.COURSE_CODE}</td>
                    <td class="px-2 py-3">${course.DESCRIPTION}</td>
                </tr>
            `;
                courseTableBody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(error => console.error('Error fetching admins and courses:', error));
</script>
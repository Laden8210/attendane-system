<section class=" bg-violet-600">
    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full  rounded-lg overflow-x-hidden overflow-y-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Course List</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class=" bg-slate-100 rounded ">
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button data-modal-target="add-course-modal" data-modal-toggle="add-course-modal" class="shadow rounded bg-blue-500 px-2 py-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                    </div>
                    <div class="flex justify-end gap-2 items-center">

                        <label for="search" class="text-black">Search</label>
                        <input name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-2 py-1" />
                    </div>
                </div>

                <div class="p-2 rounded-lg ">

                    <div class="grid grid-cols-4 gap-2" id="course-list">

                    </div>

                </div>
            </div>

        </div>
    </div>


</section>


<div id="add-course-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Add Course
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="add-course-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" id="courseForm">
                    <div>
                        <label for="course_name" class="block mb-2 text-sm font-medium text-gray-900">Course Name</label>
                        <input type="text" name="course_name" id="course_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>
  
                    <div>
                        <label for="course_image" class="block mb-2 text-sm font-medium text-gray-900">Course Image</label>
                        <input type="file" name="course_image" id="course_image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" rows="4"></textarea>
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Course</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div id="edit-course-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow ">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Edit Course
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="edit-course-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" id="editCourseForm">
                    <input type="hidden" name="course_id" id="edit-course-id">
                    <div>
                        <label for="edit-course_name" class="block mb-2 text-sm font-medium text-gray-900">Course Name</label>
                        <input type="text" name="course_name" id="edit-course_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                    </div>

                    <div>
                        <label for="edit-course_image" class="block mb-2 text-sm font-medium text-gray-900">Course Image</label>
                        <input type="file" name="course_image" id="edit-course_image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </div>
                    <div>
                        <label for="edit-description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="edit-description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" rows="4"></textarea>
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Course</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    const courseList = document.getElementById('course-list');
    fetch('controller/get_courses.php')
        .then(response => response.json())
        .then(data => {
            courseList.innerHTML = '';
            data.forEach(course => {

                const courseImage = course.COURSE_IMAGE || 'default-image.jpg';
                const courseName = course.COURSE_NAME || 'No Course Name';
                const courseDescription = course.DESCRIPTION || 'No description available';

                courseList.innerHTML += `
                <div class="bg-white shadow-md rounded-lg border border-gray-300 overflow-hidden hover:shadow-lg transition-all transform hover:-translate-y-1 flex flex-col">
                    <!-- Image Section -->
                    <div class="w-full h-40 bg-gray-200">
                        <img src="../resource/uploads/${courseImage}" alt="${courseName}" class="w-full h-full object-cover">
                    </div>
                    <!-- Content Section -->
                    <div class="p-4 flex-grow">
                        <h2 class="text-lg font-semibold text-gray-800">${courseName}</h2>
                        <p class="text-sm text-gray-600 mt-2">${courseDescription}</p>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 p-4">
                        <button class="bg-blue-600 text-white text-sm px-3 py-1 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition" onclick="editCourse(${course.ID})">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="bg-red-600 text-white text-sm px-3 py-1 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-400 focus:ring-offset-1 transition" onclick="deleteCourse(${course.ID})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });





    document.getElementById('courseForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('controller/add_course.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Message!',
                        text: data.message,
                        customClass: {
                            confirmButton: 'bg-blue-700 text-white px-5 py-2.5 rounded-lg'
                        },
                        confirmButtonText: 'Ok',
                        icon: 'success',
                        showCloseButton: true

                    }).then(() => {
                        this.reset();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Message!',
                        text: data.message,
                        customClass: {
                            confirmButton: 'bg-blue-700 text-white px-5 py-2.5 rounded-lg'
                        },
                        confirmButtonText: 'Ok',
                        icon: 'error',
                        showCloseButton: true
                    })
                }
            })
            .catch(error => {
                console.error('Error:', error);

                Swal.fire({
                    title: 'Message!',
                    text: 'Failed to add course.',
                    customClass: {
                        confirmButton: 'bg-blue-700 text-white px-5 py-2.5 rounded-lg'
                    },
                    confirmButtonText: 'Ok',
                    icon: 'error',
                    showCloseButton: true
                })
            });
    });


    // Delete course
    function deleteCourse(course_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`controller/delete_course.php?course_id=${course_id}`, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Course has been deleted.', 'success').then(() => {
                                location.reload(); // Reload to reflect changes
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting the course.', 'error');
                    });
            }
        });
    }

    function editCourse(course_id) {
        fetch(`controller/get_course.php?course_id=${course_id}`)
            .then(response => response.json())
            .then(course => {
                // Fill the edit form with the course data
                document.getElementById('edit-course-id').value = course.ID;
                document.getElementById('edit-course_name').value = course.COURSE_NAME;
                document.getElementById('edit-course_code').value = course.COURSE_CODE;
                document.getElementById('edit-description').value = course.DESCRIPTION;

                // Open the modal using Flowbite
                const modalElement = document.getElementById('edit-course-modal');
                const modal = new Modal(modalElement); // Initialize the modal
                modal.show(); // Show the modal
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to load course details.', 'error');
            });
    }


    // Update course form submission
    document.getElementById('editCourseForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('controller/update_course.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Updated!', 'Course has been updated successfully.', 'success').then(() => {
                        location.reload(); // Reload to reflect changes
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while updating the course.', 'error');
            });
    });

    function renderCourses(courses) {
        courseList.innerHTML = '';
        if (courses.length === 0) {
       
            courseList.innerHTML = `
            <div class="text-center text-gray-500 text-lg font-semibold">
                No courses found.
            </div>
        `;
            return;
        }
        courses.forEach(course => {
            const courseImage = course.COURSE_IMAGE || 'default-image.jpg';
            const courseName = course.COURSE_NAME || 'No Course Name';
            const courseDescription = course.DESCRIPTION || 'No description available';

            courseList.innerHTML += `
            <div class="bg-white shadow-md rounded-lg border border-gray-300 overflow-hidden hover:shadow-lg transition-all transform hover:-translate-y-1 flex flex-col">
                <!-- Image Section -->
                <div class="w-full h-40 bg-gray-200">
                    <img src="../resource/uploads/${courseImage}" alt="${courseName}" class="w-full h-full object-cover">
                </div>
                <!-- Content Section -->
                <div class="p-4 flex-grow">
                    <h2 class="text-lg font-semibold text-gray-800">${courseName}</h2>
                    <p class="text-sm text-gray-600 mt-2">${courseDescription}</p>
                </div>
                <!-- Action Buttons -->
                <div class="flex justify-end gap-2 p-4">
                    <button class="bg-blue-600 text-white text-sm px-3 py-1 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition" onclick="editCourse(${course.ID})">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button class="bg-red-600 text-white text-sm px-3 py-1 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-400 focus:ring-offset-1 transition" onclick="deleteCourse(${course.ID})">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        `;
        });
    }

    // Fetch and display courses initially
    let allCourses = [];
    fetch('controller/get_courses.php')
        .then(response => response.json())
        .then(data => {
            allCourses = data; // Store all courses for filtering
            renderCourses(allCourses);
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
        });

    // Add event listener for search input
    const searchInput = document.querySelector('input[name="search"]');
    searchInput.addEventListener('input', (event) => {
        const searchTerm = event.target.value.toLowerCase();
        const filteredCourses = allCourses.filter(course =>
            course.COURSE_NAME.toLowerCase().includes(searchTerm) ||
            course.COURSE_CODE.toLowerCase().includes(searchTerm) ||
            course.DESCRIPTION.toLowerCase().includes(searchTerm)
        );
        renderCourses(filteredCourses); // Render filtered courses
    });
</script>
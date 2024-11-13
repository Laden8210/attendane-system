<!-- Main modal -->
<div id="add-student-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Add New Student
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="add-student-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form enctype="multipart/form-data" class="space-y-4" id="add-student-form">
                    <div>
                        <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                        <input type="text" name="last-name" id="last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                        <input type="text" name="first-name" id="first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Course</label>
                        <select name="course" id="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Course</option>

                            <?php
                            $courses = $courseRepository->getAllCourses();
                            foreach ($courses as $course) {
                                echo "<option value='" . $course['ID'] . "'>" . $course['COURSE_CODE'] . ' - ' . $course['COURSE_NAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="block" class="block mb-2 text-sm font-medium text-gray-900">Block</label>
                        <select name="block" id="block" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">None</option>
                        <option value="1">Block 1</option>
                            <option value="2">Block 2</option>
                            <option value="3">Block 3</option>
                            <option value="4">Block 4</option>
                            <option value="5">Block 5</option>
                            <option value="6">Block 6</option>
                            <option value="7">Block 7</option>
                        </select>
                    </div>
                    <div>
                        <label for="guardian-phone" class="block mb-2 text-sm font-medium text-gray-900">Guardian Phone No.</label>
                        <input type="text" name="guardian-phone" id="guardian-phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900">Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Add student form
    const addStudentForm = document.getElementById('add-student-form');
    addStudentForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(addStudentForm);

        const response = await fetch('controller/add-student.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
            alert('Student added successfully');
            addStudentForm.reset();
            document.querySelector('[data-modal-hide="add-student-modal"]').click();
        } else {
            alert('Failed to add student');
        }
    });
</script>
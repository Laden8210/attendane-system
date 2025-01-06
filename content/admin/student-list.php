<?php



$students = $studentRepository->readByCourse($user['course_id']);
?>

<script>
    const qrCodeSize = 200;

    const textPadding = 30;


    const padding = 30;

    function generateQrCode(studentNumber, studentName) {
        const qrCanvas = document.getElementById("qrcode-" + studentNumber);
        const qrContext = qrCanvas.getContext('2d');

        const canvasHeight = qrCodeSize + textPadding;
        qrCanvas.width = qrCodeSize;
        qrCanvas.height = canvasHeight;

        qrContext.fillStyle = '#ffffff';
        qrContext.fillRect(0, 0, qrCanvas.width, qrCanvas.height);

        QrCreator.render({
            text: studentNumber,
            radius: 0.1,
            ecLevel: 'H',
            fill: '#000000',
            background: '#ffffff',
            size: qrCodeSize,
        }, qrCanvas);

        const combinedCanvas = document.createElement('canvas');
        combinedCanvas.id = "qrcode-" + studentNumber; 
        const combinedContext = combinedCanvas.getContext('2d');
        const paddedWidth = qrCodeSize + padding * 2;
        const paddedHeight = canvasHeight + padding;
        combinedCanvas.width = paddedWidth;
        combinedCanvas.height = paddedHeight;

        combinedContext.fillStyle = '#ffffff';
        combinedContext.fillRect(0, 0, combinedCanvas.width, combinedCanvas.height);

        combinedContext.drawImage(qrCanvas, padding, padding);

        const text = studentName;
        combinedContext.fillStyle = '#000000';
        combinedContext.font = '14px Arial';
        const textWidth = combinedContext.measureText(text).width;
        const textX = (combinedCanvas.width - textWidth) / 2;
        const textY = qrCodeSize + padding + 20;

        combinedContext.fillText(text, textX, textY);

        qrCanvas.parentNode.replaceChild(combinedCanvas, qrCanvas);
    }

    function downloadQRCode(studentNumber) {
        const qrCodeCanvas = document.getElementById("qrcode-" + studentNumber);
        if (!qrCodeCanvas) {
            console.error("QR Code canvas not found for student:", studentNumber);
            return;
        }
        const link = document.createElement('a');
        link.download = 'QRCode_' + studentNumber + '.png';
        link.href = qrCodeCanvas.toDataURL('image/png');
        link.click();
    }


    function searchTable() {
        const searchInput = document.getElementById("search").value.toLowerCase();
        const rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            const studentData = row.innerText.toLowerCase();
            row.style.display = studentData.includes(searchInput) ? "" : "none";
        });
    }
</script>

<section class="bg-violet-600  overflow-hidden" style="height: 85vh;">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full rounded-lg overflow-x-hidden overflow-y-auto" style="height: 80%;">
            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Student List</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="bg-slate-100 rounded" style="height: 70vh;">
                <div class="flex flex-col md:flex-row justify-between p-2 text-white">
                    <div class="mb-2 md:mb-0">
                        <button data-modal-target="add-student-modal" data-modal-toggle="add-student-modal"
                            class="shadow rounded bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 transition-colors duration-200">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </button>
                    </div>

                    <div class="flex flex-col md:flex-row justify-end gap-2 items-center">
                        <label for="search" class="text-black">Search</label>
                        <input id="search" name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-4 py-2" onkeyup="searchTable()" />
                    </div>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="text-xs uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-2 py-3">Student Number</th>
                                    <th scope="col" class="px-6 py-3">Avatar</th>
                                    <th scope="col" class="px-6 py-3">Last Name</th>
                                    <th scope="col" class="px-6 py-3">First Name</th>
                                    <th scope="col" class="px-6 py-3">Course/YL</th>
                                    <th scope="col" class="px-6 py-3">Block</th>
                                    <th scope="col" class="px-6 py-3">Guardian Phone No.</th>
                                    <th scope="col" class="px-6 py-3">QR Code</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student) {
                                    $imageData = base64_decode($student['AVATAR']);
                                    $mimeType = 'image/jpeg';
                                    $dataUrl = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                                ?>
                                    <tr class="bg-white border-b text-xs text-center">
                                        <td class="px-6 py-3"><?php echo $student['STUDENT_NUMBER'] ?></td>
                                        <td class="px-6 py-3">
                                            <div class="w-20 h-20 shadow-xl drop-shadow rounded-full flex items-center overflow-hidden">
                                                <img class="w-full h-full" src="<?php echo htmlspecialchars($dataUrl); ?>" alt="gallery-image" />
                                            </div>
                                        </td>
                                        <td class="px-6 py-3"><?php echo $student['LAST_NAME'] ?></td>
                                        <td class="px-6 py-3"><?php echo $student['FIRST_NAME'] ?></td>
                                        <td class="px-6 py-3"><?php echo $student['COURSE_NAME'] . '-' . $student['YEAR'] ?></td>
                                        <td class="px-6 py-3">Block <?php echo $student['BLOCK'] ? $student['BLOCK'] : 'No Block'; ?></td>
                                        <td class="px-6 py-3"><?php echo $student['GUARDIAN_PHONE_NO'] ?></td>
                                        <td class="px-6 py-3">
                                            <canvas id="qrcode-<?php echo $student['STUDENT_NUMBER']; ?>" class="inline-block p-2 rounded shadow">
                                                <!-- QR Code will be generated here -->
                                            </canvas>
                                            <script>
                                                generateQrCode('<?php echo $student['STUDENT_NUMBER']; ?>', '<?php echo htmlspecialchars($student['FIRST_NAME'] . ' ' . $student['LAST_NAME']); ?>');
                                            </script>
                                        </td>
                                        <td class="px-6 py-3">
                                            <button onclick="downloadQRCode('<?php echo $student['STUDENT_NUMBER']; ?>')" class="mt-2 bg-blue-500 text-white rounded px-2 py-1"><i class="fa fa-download" aria-hidden="true"></i></button>
                                            <button class="text-xs rounded bg-red-600 hover:bg-red-500 px-2 py-1 text-white"
                                                onclick="deleteStudent(<?php echo $student['STUDENT_ID']; ?>)"
                                                type="button">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                            <button class="text-xs rounded bg-yellow-500 hover:bg-yellow-400 px-2 py-1 text-white"
                                                onclick="openEditStudentModal(<?php echo htmlspecialchars(json_encode($student)); ?>)">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="edit-student-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Edit Student
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    onclick="closeEditStudentModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form enctype="multipart/form-data" class="space-y-4" id="edit-student-form">
                    <input type="hidden" name="student-id" id="edit-student-id" />
                    <div>
                        <label for="edit-last-name" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                        <input type="text" name="last-name" id="edit-last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="edit-first-name" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                        <input type="text" name="first-name" id="edit-first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>

                    <div>
                        <label for="edit-year" class="block mb-2 text-sm font-medium text-gray-900">Year</label>
                        <select name="year" id="edit-year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="1st">1st Year</option>
                            <option value="2nd">2nd Year</option>
                            <option value="3rd">3rd Year</option>
                            <option value="4th">4th Year</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-block" class="block mb-2 text-sm font-medium text-gray-900">Block</label>
                        <select name="block" id="edit-block" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="1">Block 1</option>
                            <option value="2">Block 2</option>
                            <option value="3">Block 3</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-guardian-phone" class="block mb-2 text-sm font-medium text-gray-900">Guardian Phone No.</label>
                        <input type="text" name="guardian-phone" id="edit-guardian-phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>
                    <div>
                        <label for="edit-avatar" class="block mb-2 text-sm font-medium text-gray-900">Avatar</label>
                        <input type="file" name="avatar" id="edit-avatar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function deleteStudent(studentId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                deleteStudentFromServer(studentId).then((response) => {
                    if (response.status === "success") {
                        Swal.fire({
                            title: "Deleted!",
                            text: "The student record has been deleted.",
                            icon: "success"
                        }).then(() => {

                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "There was a problem deleting the record.",
                            icon: "error"
                        });
                    }
                }).catch((error) => {
                    Swal.fire({
                        title: "Error!",
                        text: "There was a problem deleting the record.",
                        icon: "error"
                    });
                });
            }
        });
    }

    document.getElementById('edit-student-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        try {
            const response = await fetch('controller/edit-student.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    title: 'Success',
                    text: 'Student details updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none'
                    }
                }).then(() => {
                    closeEditModal();
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: result.message || 'Failed to update student.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none'
                    }
                });
            }
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: 'An unexpected error occurred.',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none'
                }
            });
        }
    });

    async function deleteStudentFromServer(studentId) {
        try {
            const response = await fetch('controller/delete-student.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: studentId
                })
            });

            if (!response.ok) {
                throw new Error('Failed to delete the student');
            }

            return response.json();
        } catch (error) {
            return Promise.reject(error);
        }
    }

    function openEditStudentModal(student) {
        document.getElementById('edit-student-id').value = student.STUDENT_ID;
        document.getElementById('edit-last-name').value = student.LAST_NAME;
        document.getElementById('edit-first-name').value = student.FIRST_NAME;
        document.getElementById('edit-year').value = student.YEAR;
        document.getElementById('edit-block').value = student.BLOCK;
        document.getElementById('edit-guardian-phone').value = student.GUARDIAN_PHONE_NO;

        document.getElementById('edit-student-modal').classList.remove('hidden');
    }

    function closeEditStudentModal() {
        document.getElementById('edit-student-modal').classList.add('hidden');
    }
</script>




<?php require_once 'modal/add-student.php'; ?>
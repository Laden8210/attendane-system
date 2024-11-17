<?php



$students = $studentRepository->readByCourse($user['course_id']);
?>

<script>
    const qrCodeSize = 200;
    const padding = 20;

    function generateQrCode(studentNumber) {
        const canvas = document.getElementById("qrcode-" + studentNumber);
        const context = canvas.getContext('2d');



        canvas.width = qrCodeSize;
        canvas.height = qrCodeSize;

        context.fillStyle = '#ffffff';
        context.fillRect(0, 0, qrCodeSize, qrCodeSize);

        QrCreator.render({
            text: studentNumber,
            radius: 0.1,
            ecLevel: 'H',
            fill: '#000',
            background: '#ffffff',
            size: qrCodeSize
        }, canvas);
    }


    function downloadQRCode(studentNumber) {
        const qrCodeCanvas = document.getElementById("qrcode-" + studentNumber);
        const paddedWidth = qrCodeSize + padding * 2;
        const paddedHeight = qrCodeSize + padding * 2;
        const paddedCanvas = document.createElement('canvas');
        paddedCanvas.width = paddedWidth;
        paddedCanvas.height = paddedHeight;
        const paddedContext = paddedCanvas.getContext('2d');
        paddedContext.fillStyle = '#ffffff';
        paddedContext.fillRect(0, 0, paddedWidth, paddedHeight);

        paddedContext.drawImage(qrCodeCanvas, padding, padding);
        const link = document.createElement('a');
        link.download = 'QRCode_' + studentNumber + '.png';
        link.href = paddedCanvas.toDataURL('image/png');
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
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button data-modal-target="add-student-modal" data-modal-toggle="add-student-modal" class="shadow rounded bg-blue-500 px-2 py-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                    </div>
                    <div class="flex justify-end gap-2 items-center">

                        <label for="search" class="text-black">Search</label>
                        <input id="search" name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-2 py-1" onkeyup="searchTable()" />
                    </div>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
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
                                    <td class="px-6 py-3"><?php echo $student['COURSE_NAME']. '-'. $student['YEAR'] ?></td>
                                    <td class="px-6 py-3">Block <?php echo $student['BLOCK'] ?></td>
                                    <td class="px-6 py-3"><?php echo $student['GUARDIAN_PHONE_NO'] ?></td>

                                    <td class="px-6 py-3">
                                        <canvas id="qrcode-<?php echo $student['STUDENT_NUMBER']; ?>" class="inline-block p-2 rounded shadow">
                                            <!-- QR Code will be generated here -->
                                        </canvas>

                                        <script>
                                            generateQrCode('<?php echo $student['STUDENT_NUMBER']; ?>');
                                        </script>
                                    </td>

                                    <td class="px-6 py-3">
                                        <button onclick="downloadQRCode('<?php echo $student['STUDENT_NUMBER']; ?>')" class="mt-2 bg-blue-500 text-white rounded px-2 py-1"><i class="fa fa-download" aria-hidden="true"></i></button>
                                        <button class="text-xs rounded bg-red-600 hover:bg-red-500 px-2 py-1 text-white"
                                            onclick="deleteStudent(<?php echo $student['STUDENT_ID']; ?>)"
                                            type="button">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
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
</section>
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

    async function deleteStudentFromServer(studentId) {
        try {
            const response = await fetch('controller/delete-student.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: studentId })
            });

            if (!response.ok) {
                throw new Error('Failed to delete the student');
            }

            return response.json();
        } catch (error) {
            return Promise.reject(error);
        }
    }
</script>


<?php require_once 'modal/add-student.php'; ?>
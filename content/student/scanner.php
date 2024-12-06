<?php
date_default_timezone_set('Asia/Manila');
$eventId = $_GET['event_id'];
$eventRepository = new EventRepository($conn);
$event = $eventRepository->getEventById($eventId);

if (!$event) {
    echo "<h1>Event not found.</h1>";
    exit;
}


$currentDate = strtotime(date('Y-m-d')); 
$eventDate = strtotime($event['event_date']); 
$eventEndDate = strtotime($event['event_date'] . ' ' . $event['pm_time_out']);

$status = '';

if ($currentDate < $eventDate) {
    $status = 'Upcoming'; 
} elseif ($currentDate > $eventEndDate) {
    $status = 'Ended'; 
} elseif ($currentDate == $eventDate) {
    $status = 'On-going'; 
}

$currentDateFormatted = date('Y-m-d', $currentDate);
$eventDateFormatted = date('Y-m-d', $eventDate);

if ($status !== 'On-going') {
    echo "<script>
        Swal.fire({
            title: 'Access Denied',
            text: 'This event is $status You cannot access the scanner.',
            icon: 'warning',
            confirmButtonText: 'Go Back'
        }).then(() => {
            window.location.href = 'index.php';
        });
    </script>";
    exit;
}

?>

<section class="w-full h-screen bg-gradient-to-br from-violet-600 to-violet-700 flex flex-col">
    <!-- Header Section -->
    <div class="bg-violet-800 py-4 px-6 text-white flex justify-between items-center shadow-md">
        <a href="index.php" class="flex items-center bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg font-medium shadow transition">
            <i class="fa fa-arrow-left mr-2"></i> Back to Events
        </a>
        <h1 class="text-xl font-bold">QR Code Scanner</h1>
    </div>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center px-6 py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl">
            <h2 class="text-2xl font-bold text-center text-violet-700 mb-6">Scan Your QR Code</h2>
            <input type="hidden" id="event_id" value="<?php echo $_GET['event_id']; ?>">

            <!-- Status Section -->
            <div class="text-center mb-4">
                <h3 id="scan-status" class="text-lg text-gray-600 font-medium">Align your QR Code within the scanner</h3>
            </div>

            <!-- QR Code Reader -->
            <div id="reader" class="w-full h-96 border-2 border-dashed border-violet-500 rounded-lg shadow-md bg-gray-50 relative overflow-hidden flex justify-center items-center">
                <p class="text-gray-400 absolute">Camera feed will appear here...</p>
            </div>

            <!-- Stop Scanning Button -->
            <!-- Stop Scanning Button -->
            <div class="text-center mt-6">
                <button id="stop-button" class="px-6 py-2 bg-red-500 text-white rounded-lg font-medium shadow-md hover:bg-red-600 transition">
                    Stop Scanning
                </button>
                <button id="start-button" class="px-6 py-2 bg-green-500 text-white rounded-lg font-medium shadow-md hover:bg-green-600 transition hidden">
                    Start Scanning
                </button>
            </div>

        </div>
    </div>
</section>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const eventId = document.getElementById('event_id').value;
    const html5QrCode = new Html5Qrcode("reader");

    const stopButton = document.getElementById("stop-button");
    const startButton = document.getElementById("start-button");

    // Stop Scanning Functionality
    stopButton.addEventListener("click", () => {
        html5QrCode.stop().then(() => {
            document.getElementById("scan-status").textContent = "Scanning stopped.";
            stopButton.classList.add("hidden"); // Hide the Stop button
            startButton.classList.remove("hidden"); // Show the Start button
        }).catch(err => console.error("Unable to stop scanning:", err));
    });

    // Start Scanning Functionality
    startButton.addEventListener("click", () => {
        startScanning(); // Restart scanning
        startButton.classList.add("hidden"); // Hide the Start button
        stopButton.classList.remove("hidden"); // Show the Stop button
    });

    // Start Scanning Function
    function startScanning() {
        html5QrCode.start({
                facingMode: "environment"
            }, // Use the environment camera
            {
                fps: 10, // Frames per second
                qrbox: {
                    width: 400,
                    height: 400
                } // Scanner box size
            },
            onScanSuccess, // Success callback
            errorMessage => {
                document.getElementById("scan-status").textContent = `Scanning... (${errorMessage})`;
            }
        ).catch(err => {
            console.error(`Unable to start scanning: ${err}`);
            document.getElementById("scan-status").textContent = "Error starting scanner.";
        });
    }


    async function displayUserInfo(qrCodeMessage) {
        const response = await fetch(`controller/get-user-info.php?qrCode=${qrCodeMessage}&event_id=${eventId}&course=${<?php echo $student['COURSE']; ?>}`);

        const userInfo = await response.json();

        if (userInfo.success) {
            Swal.fire({
                title: 'User Information',
                html: `
 <img src="data:image/png;base64,${userInfo.data.AVATAR}" class="w-24 h-24 mx-auto rounded-full mb-4" alt="User Avatar">
                    <p><strong>Name:</strong> ${userInfo.data.FIRST_NAME} ${userInfo.data.LAST_NAME}</p>
                    <p><strong>Course:</strong> ${userInfo.data.COURSE}</p>
                    <p><strong>Student ID:</strong> ${userInfo.data.STUDENT_ID}</p>
                    <p><strong>Year:</strong> ${userInfo.data.YEAR}</p>
                    <p><strong>Course:</strong> ${userInfo.data.COURSE}</p>
                    <p><strong>Contact Number:</strong> ${userInfo.data.CONTACT_NUMBER}</p>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Confirm Attendance',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'bg-green-500 text-white px-4 py-2 rounded',
                    cancelButton: 'bg-red-500 text-white px-4 py-2 rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmAttendance(qrCodeMessage);
                } else {
                    startScanning();
                }
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: userInfo.message,
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => startScanning());
        }
    }

    function onScanSuccess(qrCodeMessage) {
        html5QrCode.stop().then(() => {
            document.getElementById("scan-status").textContent = `Scanned: ${qrCodeMessage}. Retrieving user info...`;
            displayUserInfo(qrCodeMessage);
        }).catch(err => {
            console.error("Unable to stop scanning:", err);
        });
    }

    function confirmAttendance(qrCodeMessage) {
        fetch('controller/save-attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    qrCode: qrCodeMessage,
                    event_id: eventId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Attendance successfully recorded.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    document.getElementById("scan-status").textContent = `Attendance recorded successfully.`;
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to save attendance.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
                setTimeout(() => startScanning(), 3000);
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while saving attendance.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                setTimeout(() => startScanning(), 1000);
            });
    }

    function startScanning() {
        html5QrCode.start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: {
                    width: 400,
                    height: 400
                }
            },
            onScanSuccess,
            errorMessage => {
 
            }
        ).catch(err => {
            console.error(`Unable to start scanning: ${err}`);
            document.getElementById("scan-status").textContent = "Error starting scanner.";
        });
    }



    startScanning();
</script>
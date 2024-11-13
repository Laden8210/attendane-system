<?php require_once '../template/student-header.php';

$eventId = $_GET['event_id']; 
$eventRepository = new EventRepository($conn);
$event = $eventRepository->getEventById($eventId);

if (!$event) {
    echo "<h1>Event not found.</h1>";
    exit;
}

$currentDateTime = strtotime(date('Y-m-d H:i:s'));
$eventDate = strtotime($event['event_date']);
$status = '';

if ($currentDateTime < $eventDate) {
    $status = 'Upcoming';
} elseif ($currentDateTime > strtotime($event['event_date'] . ' ' . $event['pm_time_out'])) {
    $status = 'Ended';
} else {
    $status = 'On-going';
}

if ($status !== 'On-going') {
    echo "<script>
        Swal.fire({
            title: 'Access Denied',
            text: 'This event is $status. You cannot access the scanner.',
            icon: 'warning',
            confirmButtonText: 'Go Back'
        }).then(() => {
            window.location.href = 'index.php';
        });
    </script>";
    exit;
}
?>

<section class="w-full h-screen bg-violet-600">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full rounded-lg overflow-auto h-full">
            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Scan your QR Code here</h1>
                <hr class="h-2 bg-cyan-500">
            </div>

            <div class="flex justify-center m-10">
                <div>
                    <input type="hidden" id="event_id" value="<?php echo $_GET['event_id']?>">
                    <h2 class="text-center" id="scan-status">Scanning...</h2>
                    <div id="user-info" class="mb-5"></div>
                    <div id="reader" class="h-96 w-96 rounded-lg shadow-lg"></div>
                    <button id="stop-button" class="mt-5 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Stop Scanning</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const eventId = document.getElementById('event_id').value;
    const html5QrCode = new Html5Qrcode("reader");

    async function displayUserInfo(qrCodeMessage) {
        const response = await fetch(`controller/get-user-info.php?qrCode=${qrCodeMessage}&event_id=${eventId}`);
        const userInfo = await response.json();

        if (userInfo.success) {
            // Display user info in a SweetAlert modal with a Confirm button
            Swal.fire({
                title: 'User Information',
                html: `

                    <p><strong>Name:</strong> ${userInfo.data.FIRST_NAME} ${userInfo.data.LAST_NAME}</p>
                    <p><strong>Course:</strong> ${userInfo.data.COURSE}</p>
                    <p><strong>Student ID:</strong> ${userInfo.data.STUDENT_ID}</p>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Confirm Attendance',
                cancelButtonText: 'Cancel'
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
                text: 'User information not found.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                startScanning();
            });
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
            body: JSON.stringify({ qrCode: qrCodeMessage, event_id: eventId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Attendance successfully saved.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                document.getElementById("scan-status").textContent = `Attendance recorded successfully`;
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
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
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 500 },
            onScanSuccess,
            errorMessage => console.warn(`QR Code scanning error: ${errorMessage}`)
        ).catch(err => console.error(`Unable to start scanning: ${err}`));
    }

    document.getElementById("stop-button").addEventListener("click", () => {
        html5QrCode.stop().then(() => {
            document.getElementById("scan-status").textContent = "Scanning stopped.";
            
        }).catch(err => console.error("Unable to stop scanning:", err));
    });

    startScanning();
</script>

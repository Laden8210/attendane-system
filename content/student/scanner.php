<?php require_once '../template/student-header.php';

$eventId = $_GET['event_id']; // Assuming event_id is passed in the URL
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

// Block access if the event is "Upcoming" or "Ended" using Swal
if ($status !== 'On-going') {
    echo "<script>
        Swal.fire({
            title: 'Access Denied',
            text: 'This event is $status. You cannot access the scanner.',
            icon: 'warning',
            confirmButtonText: 'Go Back'
        }).then(() => {
            window.location.href = 'index.php'; // Redirect to the event listing or another page
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

    function startScanning() {
        // Start scanning
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 500
            },
            onScanSuccess,
            onScanError
        ).catch(err => {
            console.error(`Unable to start scanning: ${err}`);
        });
    }

    function onScanSuccess(qrCodeMessage) {

        html5QrCode.stop().then(() => {
            document.getElementById("scan-status").textContent = `Scanned: ${qrCodeMessage}. Waiting for response...`;


            fetch('controller/save-attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ qrCode: qrCodeMessage, event_id: eventId })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);

                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Attendance successfully saved.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    document.getElementById("scan-status").textContent = `Attendance record successfully`;
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    document.getElementById("scan-status").textContent = `Attendance record unsuccessfully`;
                }

       
                setTimeout(() => {
                    startScanning();
                }, 3000); 
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while saving attendance.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });


                setTimeout(() => {
                    startScanning();
                }, 1000);
            });
        }).catch(err => {
            console.error("Unable to stop scanning:", err);
        });
    }

    function onScanError(errorMessage) {

        console.warn(`QR Code scanning error: ${errorMessage}`);
    }


    startScanning();


    document.getElementById("stop-button").addEventListener("click", () => {
        html5QrCode.stop().then(ignore => {
            document.getElementById("scan-status").textContent = "Scanning stopped.";
        }).catch(err => {
            console.error("Unable to stop scanning:", err);
        });
    });
</script>

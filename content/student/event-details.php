<?php

$id = $_GET['id'];



$event = $eventRepository->getEventById($id);


$attendees = $attendanceRepository->getAttendanceByEvent($id);

?>
<section class="w-full bg-violet-600 min-h-screen">
    <!-- Header with Back Button -->
    <div class="bg-violet-700 py-4 px-6 flex items-center justify-between">
        <a href="index.php" class="text-white bg-cyan-500 hover:bg-cyan-600 px-4 py-2 rounded-lg flex items-center font-semibold shadow-md">
            <i class="fa fa-arrow-left mr-2"></i> Back to Events
        </a>
        <h1 class="text-white text-2xl font-bold">Event Details</h1>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-10">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Event Overview -->
            <h2 class="text-3xl font-extrabold text-center text-violet-700 mb-6"><?php echo htmlspecialchars($event['event_name']); ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Event Title</h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($event['event_name']); ?></p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Event Start</h3>
                    <p class="text-gray-600"><?php echo date('h:i A', strtotime($event['am_time_in'])) . " / " . date('h:i A', strtotime($event['pm_time_in'])); ?></p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Event Venue</h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($event['details']); ?></p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Event End</h3>
                    <p class="text-gray-600"><?php echo date('h:i A', strtotime($event['am_time_out'])) . " / " . date('h:i A', strtotime($event['pm_time_out'])); ?></p>
                </div>
                <div class="col-span-2">
                    <h3 class="text-lg font-semibold text-gray-700">Event Description</h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($event['description']); ?></p>
                </div>
            </div>

            <!-- QR Scan Button -->
            <div class="text-center mt-8">
                <a href="index.php?view=scanner&event_id=<?php echo $id ?>" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md">
                    Scan QR Code
                </a>
            </div>
        </div>


        <!-- Attendee Section -->
        <div class="mt-10 bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-violet-700">Present Attendees</h2>
                <div class="relative">
                    <input type="text" id="search" placeholder="Search attendees..." class="w-full md:w-64 p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500">
                </div>
            </div>

            <div id="attendee-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($attendees as $attendee): ?>
                    <div class="bg-violet-100 border border-violet-300 p-4 rounded-lg flex flex-col items-start shadow-md hover:bg-violet-200">
                          <p class="font-semibold text-violet-700"><?php echo htmlspecialchars($attendee['FIRST_NAME'] . ' ' . $attendee['LAST_NAME']); ?></p>
                        <p class="text-sm text-gray-600">Student No: <?php echo htmlspecialchars($attendee['STUDENT_NUMBER']); ?></p>
                        <p class="text-sm text-gray-600">Course: <?php echo htmlspecialchars($attendee['COURSE']); ?></p>
                        <p class="text-sm text-gray-600">Year: <?php echo htmlspecialchars($attendee['YEAR']); ?></p>
                        <hr class="my-2">
                        <h3 class="font-medium text-gray-700">Attendance Details:</h3>
                        <pre class="text-sm text-gray-600 whitespace-pre-wrap"><?php echo htmlspecialchars($attendee['attendance_details']); ?></pre>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


    </div>
</section>

<script>
document.getElementById('search').addEventListener('input', function () {
    const searchTerm = this.value.trim().toLowerCase();
    const eventId = <?php echo json_encode($id); ?>;
    const attendeeList = document.getElementById('attendee-list');

    fetch('controller/search-attendees.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ event_id: eventId, search: searchTerm })
    })
    .then(response => response.json())
    .then(data => {
        attendeeList.innerHTML = '';
        if (data.success && data.attendees.length > 0) {
            data.attendees.forEach(attendee => {
                attendeeList.innerHTML += `
                    <div class="bg-violet-100 border border-violet-300 p-4 rounded-lg flex flex-col items-start shadow-md hover:bg-violet-200">
    
                        <p class="font-semibold text-violet-700">${attendee.FIRST_NAME} ${attendee.LAST_NAME}</p>
                        <p class="text-sm text-gray-600">Student No: ${attendee.STUDENT_NUMBER}</p>
                        <p class="text-sm text-gray-600">Course: ${attendee.COURSE}</p>
                        <p class="text-sm text-gray-600">Year: ${attendee.YEAR}</p>
                        <hr class="my-2">
                        <h3 class="font-medium text-gray-700">Attendance Details:</h3>
                        <pre class="text-sm text-gray-600 whitespace-pre-wrap">${attendee.attendance_details}</pre>
                    </div>`;
            });
        } else {
            attendeeList.innerHTML = '<p class="text-gray-500 col-span-full text-center">No attendees found.</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

</script>
<?php

$id = $_GET['id'];



$event = $eventRepository->getEventById($id);


$attendees = $attendanceRepository->getAttendanceByEvent($id);

?>

<section class="w-full  bg-violet-600" style="height: 100vh;">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full rounded-lg overflow-auto">
            <div class="pt-10 px-2">
                <hr class="h-2 bg-cyan-500">
            </div>

            <div class="text-center mt-2">
                <a href="index.php?view=scanner&event_id=<?php echo $id ?>" class="rounded shadow-lg px-3 py-1 bg-cyan-500 text-white">Scan QR</a>
            </div>

            <div class="flex justify-center items-center py-5 px-7 ">
                <div class="border drop-shadow shadow-xl rounded bg-slate-100 w-full p-2">
                    <div class="text-center mt-2">
                        <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($event['event_name']); ?></h1>
                    </div>

                    <div class="grid grid-cols-2 gap-5 ps-10 mt-10">
                        <div>
                            <h1 class="text-xl font-semibold">Event Title</h1>
                            <p class="text-lg ps-5"><?php echo htmlspecialchars($event['event_name']); ?></p>
                        </div>

                        <div>
                            <h1 class="text-xl font-semibold">Event Start</h1>
                            <div class="flex">
                                <p class="text-lg ps-5"><?php echo date('h:i A', strtotime($event['am_time_in'])); ?></p>
                                <p class="text-lg ps-5"><?php echo date('h:i A', strtotime($event['pm_time_in'])); ?></p>
                            </div>
                        </div>

                        <div>
                            <h1 class="text-xl font-semibold">Event Venue</h1>
                            <p class="text-lg ps-5"><?php echo htmlspecialchars($event['details']); ?></p>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold">Event End</h1>
                            <div class="flex">
                                <p class="text-lg ps-5"><?php echo date('h:i A', strtotime($event['am_time_out'])); ?></p>
                                <p class="text-lg ps-5"><?php echo date('h:i A', strtotime($event['pm_time_out'])); ?></p>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold">Event Description</h1>
                            <p class="text-lg ps-5"><?php echo htmlspecialchars($event['description']); ?></p>
                        </div>

                        <div>
                            <h1 class="text-xl font-semibold">Registration Cut-off Time</h1>
                            <div class="flex">
                                <p class="text-lg ps-5">
                                    <?php
                                    // Calculate morning cut-off time as one hour after morning start
                                    if (!empty($event['am_time_in'])) {
                                        $amCutoffTime = date('h:i A', strtotime($event['am_time_in'] . ' +1 hour'));
                                        echo "Morning: " . $amCutoffTime;
                                    }
                                    ?>
                                </p>
                                <p class="text-lg ps-5">
                                    <?php
                                    // Calculate afternoon cut-off time as one hour after afternoon start
                                    if (!empty($event['pm_time_in'])) {
                                        $pmCutoffTime = date('h:i A', strtotime($event['pm_time_in'] . ' +1 hour'));
                                        echo "Afternoon: " . $pmCutoffTime;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div class="flex justify-between p-2">
                    <div class="text-2xl font-bold ms-2">Present Attendees</div>
                    <div class="items-center">
                        <div class="relative">
                            <input type="text" name="search" id="search" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Search">
                            <button type="button" id="toggleSearch" class="absolute inset-y-0 right-0 px-3 text-gray-500">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-2">
                    <div class="grid grid-cols-5 gap-2" id="attendee-list">
                        <?php foreach ($attendees as $attendee): ?>
                            <div class="border-2 border-slate-500 p-2 h-20 flex justify-center items-center">
                                <p class="text-center"><?php echo htmlspecialchars($attendee['FIRST_NAME'] . ' ' . $attendee['LAST_NAME']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.getElementById('search').addEventListener('input', function() {
        const searchTerm = this.value;
        const eventId = <?php echo json_encode($id); ?>;
        const attendeeList = document.getElementById('attendee-list');

        // Send search term to server and update attendee list
        fetch('controller/search-attendees.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    event_id: eventId,
                    search: searchTerm
                })
            })
            .then(response => response.json())
            .then(data => {
                attendeeList.innerHTML = ''; // Clear current attendees

                if (data.success) {
                    data.attendees.forEach(attendee => {
                        const attendeeDiv = document.createElement('div');
                        attendeeDiv.className = 'border-2 border-slate-500 p-2 h-20 flex justify-center items-center';
                        attendeeDiv.innerHTML = `<p class="text-center">${attendee.FIRST_NAME} ${attendee.LAST_NAME}</p>`;
                        attendeeList.appendChild(attendeeDiv);
                    });
                } else {
                    attendeeList.innerHTML = '<p class="text-center">No attendees found.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
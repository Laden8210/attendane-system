<section class="bg-violet-600 h-screen overflow-auto">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full h-screen rounded-lg overflow-x-hidden overflow-y-auto ">
            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Event Report List</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded ">
                <div class="flex justify-end p-2 text-white">

                    <div class="flex justify-end gap-2 items-center">

                        <label for="search" class="text-black">Search</label>
                        <input name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-2 py-1" id="search" />
                    </div>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full h-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Details</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Time AM - PM</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $events = $eventRepository->getEventByCourse($user['course_id']); ?>
                            <?php foreach ($events as $event) : ?>

                                <tr class="bg-white border-b text-xs text-center">
                                    <td class="px-2 py-3"><?= $event['id'] ?></td>
                                    <td class="px-6 py-3"><?= $event['event_name'] ?></td>
                                    <td class="px-6 py-3"><?= date('F j, Y', strtotime($event['event_date'])) ?></td>
                                    <td class="px-6 py-3"><?= $event['description'] ?></td>
                                    <td class="px-6 py-3"><?= $event['details'] ?></td>

                                    <td class="px-6 py-3">
                                        <?php
                                        $currentDate = date('Y-m-d');
                                        $currentTime = date('H:i:s');
                                        $eventDate = $event['event_date'];
                                        $amTimeIn = date('H:i:s', strtotime($event['am_time_in']));
                                        $amTimeOut = date('H:i:s', strtotime($event['am_time_out']));
                                        $pmTimeIn = date('H:i:s', strtotime($event['pm_time_in']));
                                        $pmTimeOut = date('H:i:s', strtotime($event['pm_time_out']));

                                        $status = '';
                                        $isEventDone = false; // Initialize a flag for "Done" status

                                        if ($currentDate < $eventDate) {
                                            $status = '<span class="px-2 py-1 text-white bg-blue-500 rounded-full">Upcoming</span>';
                                        } elseif ($currentDate == $eventDate) {
                                            if ($currentTime < $amTimeIn) {
                                                $status = '<span class="px-2 py-1 text-white bg-blue-500 rounded-full">Upcoming</span>';
                                            } elseif ($currentTime >= $amTimeIn && $currentTime <= $amTimeOut) {
                                                $status = '<span class="px-2 py-1 text-white bg-green-500 rounded-full">Ongoing (AM)</span>';
                                            } elseif ($currentTime > $amTimeOut && $currentTime < $pmTimeIn) {
                                                $status = '<span class="px-2 py-1 text-white bg-yellow-500 rounded-full">Break</span>';
                                            } elseif ($currentTime >= $pmTimeIn && $currentTime <= $pmTimeOut) {
                                                $status = '<span class="px-2 py-1 text-white bg-green-500 rounded-full">Ongoing (PM)</span>';
                                            } else {
                                                $status = '<span class="px-2 py-1 text-white bg-red-500 rounded-full">Done</span>';
                                                $isEventDone = true; // Mark event as done
                                            }
                                        } else {
                                            $status = '<span class="px-2 py-1 text-white bg-red-500 rounded-full">Done</span>';
                                            $isEventDone = true; // Mark event as done
                                        }
                                        echo $status;
                                        ?>
                                    </td>

                                    <td class="px-6 py-3">
                                        <?= date('g:i A', strtotime($event['am_time_in'])) . ' - ' . date('g:i A', strtotime($event['am_time_out'])) . ' : ' . date('g:i A', strtotime($event['pm_time_in'])) . ' - ' . date('g:i A', strtotime($event['pm_time_out'])) ?>
                                    </td>

                                    <td class="px-6 py-3">
                                        <?php if ($isEventDone): ?>
                                            <button class="bg-green-500 px-2 py-1 rounded text-white" onclick="downloadReport(<?= $event['id'] ?>)">Download Report</button>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Download Report Function -->
<script>
    async function downloadReport(eventId) {
        try {
            const response = await fetch(`controller/get-event-report.php?event_id=${eventId}`, {
                method: 'GET',
            });

            if (!response.ok) {
                throw new Error('Failed to generate report.');
            }

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `event_${eventId}_attendance_report.pdf`; // The PDF report name
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        } catch (error) {
            Swal.fire('Error!', error.message, 'error');
        }
    }
</script>
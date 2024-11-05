<section class=" bg-violet-600 h-screen overflow-auto">
    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full h-screen rounded-lg overflow-x-hidden overflow-y-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Event List</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded ">
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button data-modal-target="add-event-modal" data-modal-toggle="add-event-modal" class="shadow rounded bg-blue-500 px-2 py-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                    </div>
                    <div class="flex justify-end gap-2 items-center">
                        <button class="shadow rounded bg-green-500 px-2 py-1">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filter
                        </button>
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

                            <?php $events = $eventRepository->getAllEvents() ?>

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
                                        $currentTime = date('h:i:s A');
                                        $eventDate = $event['event_date'];
                                        $amTimeIn = date('h:i A', strtotime($event['am_time_in']));
                                        $amTimeOut = date('h:i A', strtotime($event['am_time_out']));
                                        $pmTimeIn = date('h:i A', strtotime($event['pm_time_in']));
                                        $pmTimeOut = date('h:i A', strtotime($event['pm_time_out']));

                                        $status = '';

                                        if ($currentDate == $eventDate) {

                                            if ($currentTime >= $amTimeIn && $currentTime <= $amTimeOut) {
                                                $status = '<span class="px-2 py-1 text-white bg-green-500 rounded-full">Ongoing</span>';
                                            } elseif ($currentTime >= $pmTimeIn && $currentTime <= $pmTimeOut) {
                                                $status = '<span class="px-2 py-1 text-white bg-green-500 rounded-full">Ongoing</span>';
                                            } elseif ($currentTime > $amTimeOut && $currentTime < $pmTimeIn) {
                                                $status = '<span class="px-2 py-1 text-white bg-yellow-500 rounded-full">Break</span>';
                                            } else {
                                                $status = '<span class="px-2 py-1 text-white bg-red-500 rounded-full">Done</span>';
                                            }
                                        } else {

                                            $status = '<span class="px-2 py-1 text-white bg-blue-500 rounded-full">Upcoming</span>';
                                        }

                                        echo $status;
                                        ?>

                                    </td>
                                    <td class="px-6 py-3">
                                        <?=
                                        date('g:i A', strtotime($event['am_time_in'])) . ' - ' .
                                            date('g:i A', strtotime($event['am_time_out'])) . ' : ' .
                                            date('g:i A', strtotime($event['pm_time_in'])) . ' - ' .
                                            date('g:i A', strtotime($event['pm_time_out']));
                                        ?>
                                    </td>
                                    <td class="px-6 py-3">
                                        <button class="bg-blue-500 px-2 py-1 rounded text-white">Edit</button>
                                        <button class="bg-red-500 px-2 py-1 rounded text-white">Delete</button>
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


<!-- Main modal -->
<div id="add-event-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Add Event
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="add-event-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" id="eventForm">

                    <div>
                        <label for="event-name" class="block mb-2 text-sm font-medium text-gray-900 ">Event Name</label>
                        <input type="text" name="event_name" id="event-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>

                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Description</label>
                        <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required></textarea>
                    </div>

                    <div>
                        <label for="details" class="block mb-2 text-sm font-medium text-gray-900 ">Details</label>
                        <textarea name="details" id="details" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required></textarea>
                    </div>

                    <label class="block mb-2 text-sm font-medium text-gray-900 ">AM - TIME</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="am-time-in" class="block mb-2 text-sm font-medium text-gray-900 ">Time In </label>
                            <input type="time" name="am_time_in" id="am-time-in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <div>
                            <label for="am-time-out" class="block mb-2 text-sm font-medium text-gray-900 ">Time Out</label>
                            <input type="time" name="am_time_out" id="am-time-out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>
                    </div>

                    <label class="block mb-2 text-sm font-medium text-gray-900 ">PM - TIME</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="pm-time-in" class="block mb-2 text-sm font-medium text-gray-900 ">Time In </label>
                            <input type="time" name="pm_time_in" id="pm-time-in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <div>
                            <label for="pm-time-out" class="block mb-2 text-sm font-medium text-gray-900 ">Time Out</label>
                            <input type="time" name="pm_time_out" id="pm-time-out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>
                    </div>

                    <div>
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 ">Date</label>
                        <input type="date" name="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required />
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Event</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    const eventForm = document.getElementById('eventForm');
    eventForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(eventForm);
        const response = await fetch('controller/add-event.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        console.log(data);

        // Use SweetAlert to display messages based on the response
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
                confirmButtonText: 'OK'
            }).then(() => {

                eventForm.reset();

            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                confirmButtonText: 'Try Again'
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowContainsSearchTerm = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        rowContainsSearchTerm = true;
                    }
                });


                if (rowContainsSearchTerm) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
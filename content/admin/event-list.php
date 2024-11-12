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
                            <?php $events = $eventRepository->getAllEvents(); ?>
                            <?php foreach ($events as $event) : ?>
                                <tr class="bg-white border-b text-xs text-center">
                                    <td class="px-2 py-3"><?= $event['id'] ?></td>
                                    <td class="px-6 py-3"><?= $event['event_name'] ?></td>
                                    <td class="px-6 py-3"><?= date('F j, Y', strtotime($event['event_date'])) ?></td>
                                    <td class="px-6 py-3"><?= $event['description'] ?></td>
                                    <td class="px-6 py-3"><?= $event['details'] ?></td>

                                    <!-- Event Status Logic -->
                                    <td class="px-6 py-3">
                                        <?php
                                        // Get current date and time
                                        $currentDate = date('Y-m-d');
                                        $currentTime = date('H:i:s');

                                        // Event times
                                        $eventDate = $event['event_date'];
                                        $amTimeIn = date('H:i:s', strtotime($event['am_time_in']));
                                        $amTimeOut = date('H:i:s', strtotime($event['am_time_out']));
                                        $pmTimeIn = date('H:i:s', strtotime($event['pm_time_in']));
                                        $pmTimeOut = date('H:i:s', strtotime($event['pm_time_out']));

                              
                                        $status = '';

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
                                            }
                                        } else {
                            
                                            $status = '<span class="px-2 py-1 text-white bg-red-500 rounded-full">Done</span>';
                                        }

                                        echo $status;
                                        ?>
                                    </td>

                 
                                    <td class="px-6 py-3">
                                        <?=
                                        date('g:i A', strtotime($event['am_time_in'])) . ' - ' . date('g:i A', strtotime($event['am_time_out'])) . ' : ' .
                                            date('g:i A', strtotime($event['pm_time_in'])) . ' - ' . date('g:i A', strtotime($event['pm_time_out']))
                                        ?>
                                    </td>


                                    <td class="px-6 py-3">
                                        <button class="bg-blue-500 px-2 py-1 rounded text-white" onclick="editEvent(<?= $event['id'] ?>)">Edit</button>
                                        <button class="bg-red-500 px-2 py-1 rounded text-white" onclick="deleteEvent(<?= $event['id'] ?>)">Delete</button>
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
<div id="edit-event-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow ">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900 ">Edit Event</h3>
                <button
                data-modal-hide="edit-event-modal"
                type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="edit-event-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 1" />
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form class="space-y-4" id="editEventForm">
                    <input type="hidden" name="event_id" id="edit-event-id" />
                    <div>
                        <label for="edit-event-name" class="block mb-2 text-sm font-medium text-gray-900 ">Event Name</label>
                        <input type="text" name="event_name" id="edit-event-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                    </div>

                    <div>
                        <label for="edit-description" class="block mb-2 text-sm font-medium text-gray-900 ">Description</label>
                        <textarea name="description" id="edit-description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required></textarea>
                    </div>

                    <div>
                        <label for="edit-details" class="block mb-2 text-sm font-medium text-gray-900 ">Details</label>
                        <textarea name="details" id="edit-details" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required></textarea>
                    </div>

                    <div>
                        <label for="edit-event-date" class="block mb-2 text-sm font-medium text-gray-900 ">Event Date</label>
                        <input type="date" name="event_date" id="edit-event-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                    </div>

                    <label class="block mb-2 text-sm font-medium text-gray-900 ">AM Time</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="edit-am-time-in" class="block mb-2 text-sm font-medium text-gray-900 ">Time In</label>
                            <input type="time" name="am_time_in" id="edit-am-time-in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                        </div>
                        <div>
                            <label for="edit-am-time-out" class="block mb-2 text-sm font-medium text-gray-900 ">Time Out</label>
                            <input type="time" name="am_time_out" id="edit-am-time-out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                        </div>
                    </div>

                    <label class="block mb-2 text-sm font-medium text-gray-900 ">PM Time</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="edit-pm-time-in" class="block mb-2 text-sm font-medium text-gray-900 ">Time In</label>
                            <input type="time" name="pm_time_in" id="edit-pm-time-in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                        </div>
                        <div>
                            <label for="edit-pm-time-out" class="block mb-2 text-sm font-medium text-gray-900 ">Time Out</label>
                            <input type="time" name="pm_time_out" id="edit-pm-time-out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                        </div>
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">Update Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Event Modal -->
<div id="add-event-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Add New Event</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="add-event-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 1" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-4">
                <form id="addEventForm" class="space-y-4">
                    <div>
                        <label for="event-name" class="block mb-2 text-sm font-medium text-gray-900">Event Name</label>
                        <input type="text" name="event_name" id="event-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required></textarea>
                    </div>
                    <div>
                        <label for="details" class="block mb-2 text-sm font-medium text-gray-900">Details</label>
                        <textarea name="details" id="details" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required></textarea>
                    </div>
                    <div>
                        <label for="event-date" class="block mb-2 text-sm font-medium text-gray-900">Event Date</label>
                        <input type="date" name="event_date" id="event-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">AM Time</label>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="am-time-in" class="block mb-2 text-sm font-medium text-gray-900">Time In</label>
                                <input type="time" name="am_time_in" id="am-time-in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                            </div>
                            <div>
                                <label for="am-time-out" class="block mb-2 text-sm font-medium text-gray-900">Time Out</label>
                                <input type="time" name="am_time_out" id="am-time-out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">PM Time</label>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="pm-time-in" class="block mb-2 text-sm font-medium text-gray-900">Time In</label>
                                <input type="time" name="pm_time_in" id="pm-time-in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                            </div>
                            <div>
                                <label for="pm-time-out" class="block mb-2 text-sm font-medium text-gray-900">Time Out</label>
                                <input type="time" name="pm_time_out" id="pm-time-out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">Add Event</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

document.addEventListener('DOMContentLoaded', function () {
    const addEventForm = document.getElementById('addEventForm');

    addEventForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(addEventForm);

        try {
            const response = await fetch('controller/add-event.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            if (data.status === 'success') {
                Swal.fire({
                    title: 'Success',
                    text: 'Event added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Hide the modal and reload the page to show the new event
                    const modal = new Modal(document.getElementById('add-event-modal'));
                    modal.hide();
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Failed to add event. Please try again.', 'error');
        }
    });
});

    
    async function deleteEvent(eventId) {
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
                fetch(`controller/delete-event.php`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: eventId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', 'Your event has been deleted.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch((error) => Swal.fire('Error!', 'Failed to delete event.', 'error'));
            }
        });
    }
    function editEvent(eventId) {
    fetch(`controller/get-event.php?id=${eventId}`)
        .then(response => response.json())
        .then(data => {
 
            document.getElementById('edit-event-id').value = data.event.id;
            document.getElementById('edit-event-name').value = data.event.event_name;
            document.getElementById('edit-description').value = data.event.description;
            document.getElementById('edit-details').value = data.event.details;
            document.getElementById('edit-event-date').value = data.event.event_date;
            document.getElementById('edit-am-time-in').value = data.event.am_time_in;
            document.getElementById('edit-am-time-out').value = data.event.am_time_out;
            document.getElementById('edit-pm-time-in').value = data.event.pm_time_in;
            document.getElementById('edit-pm-time-out').value = data.event.pm_time_out;

            const modal = new Modal(document.getElementById('edit-event-modal'));
            modal.show();
        })
        .catch(error => console.error('Error fetching event data:', error));
}


    const editEventForm = document.getElementById('editEventForm');
    editEventForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(editEventForm);
        const response = await fetch('controller/update-event.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();

        if (data.status === 'success') {
            Swal.fire('Success', 'Event updated successfully.', 'success').then(() => {
                location.reload(); // Reload the page after updating
            });
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    });

    // Search functionality
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
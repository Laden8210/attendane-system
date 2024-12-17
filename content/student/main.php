<?php
date_default_timezone_set('Asia/Manila');
require_once '../template/student-header.php';

$search = isset($_GET['search']) ? $_GET['search'] : ''; 
$events = $eventRepository->getEventByCourseAndSearch($student['COURSE'], $search);

?>
<section class="w-full h-screen bg-violet-600">
    <div class="w-full px-10 py-5" style="height: 90vh;">
        <div class="bg-slate-50 w-full h-full rounded-lg overflow-auto">
            <div class="pt-10 px-2">
                <hr class="h-2 bg-cyan-500">
            </div>

            <div class="flex justify-end p-2">
                <div class="items-center">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="w-full p-2 outline-none rounded border border-gray-300"
                            placeholder="Search Event"
                            value="<?php echo htmlspecialchars($search); ?>"
                            onkeyup="searchEvents()">
                    </div>
                </div>
            </div>

            <div class="p-2 overflow-auto">
                <div id="event-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php if (count($events) > 0): ?>
                        <?php foreach ($events as $event): ?>
                            <a href="index.php?view=event-details&id=<?php echo $event['id']; ?>">
                                <div class="bg-white rounded drop-shadow px-4 hover:transform hover:scale-105 transition-transform duration-300">
                                    <div class="border-s-4 border-cyan-900 h-full">
                                        <div class="p-1">
                                            <h1 class="text-xl font-bold"><?php echo htmlspecialchars($event['event_name']); ?></h1>
                                            <h2 class="text-slate-500 text-xs"><?php echo date('F j, Y', strtotime($event['event_date'])); ?></h2>
                                            <p class="text-base"><span class="font-bold">Morning:</span> <?php echo date('h:i A', strtotime($event['am_time_in'])); ?> - <?php echo date('h:i A', strtotime($event['am_time_out'])); ?></p>
                                            <p class="text-base"><span class="font-bold">Afternoon:</span> <?php echo date('h:i A', strtotime($event['pm_time_in'])); ?> - <?php echo date('h:i A', strtotime($event['pm_time_out'])); ?></p>

                                            <div class="text-end">
                                                <div class="text-end">
                                                    <span class="<?php echo (strtotime($event['event_date']) < strtotime(date('Y-m-d'))) ? 'text-red-500' : ((strtotime($event['event_date']) == strtotime(date('Y-m-d'))) ? 'text-green-500' : 'text-blue-500'); ?>">
                                                        <?php
                                                        echo (strtotime($event['event_date']) < strtotime(date('Y-m-d')))
                                                            ? 'Past'
                                                            : ((strtotime($event['event_date']) == strtotime(date('Y-m-d')))
                                                                ? 'On-going'
                                                                : 'Upcoming');
                                                        ?>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center">
                            <p class="text-xl text-gray-500">No events found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function searchEvents() {
        const searchInput = document.getElementById('search').value;

        fetch(`index.php?search=${encodeURIComponent(searchInput)}`)
            .then(response => response.text())
            .then(html => {

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newEventList = doc.querySelector('#event-list').innerHTML;
                document.querySelector('#event-list').innerHTML = newEventList;
            })
            .catch(error => console.error('Error fetching events:', error));
    }
</script>
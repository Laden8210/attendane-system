<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';


$smsNotifications = $smsNotificationRepository->getAllSMSNotifications($search,$user['course_id']);
?>

<section class="bg-violet-600 h-screen overflow-auto">
    <div class="w-full px-10 py-5">
        <div class="bg-slate-50 w-full rounded-lg overflow-x-hidden overflow-y-auto">
            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">SMS Notification</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded">
                <div class="flex justify-end p-2 text-white">
                    <div class="flex justify-end gap-2 items-center">
                        <label for="search" class="text-black">Search</label>
                        <input 
                            id="search-input" 
                            name="search" 
                            type="search" 
                            placeholder="Search" 
                            value="<?php echo htmlspecialchars($search); ?>" 
                            class="text-black outline-none border border-slate-700 px-2 py-1" 
                            onkeyup="searchTable()"
                        />
                    </div>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3">Recipients</th>
                                <th scope="col" class="px-6 py-3">Message</th>
                                <th scope="col" class="px-2 py-3">Date/Time</th>
                            </tr>
                        </thead>
                        <tbody id="sms-table-body">
                            <?php if (count($smsNotifications) > 0): ?>
                                <?php foreach ($smsNotifications as $notification): ?>
                                    <tr class="bg-white border-b text-xs text-center">
                                        <td class="px-2 py-3"><?php echo htmlspecialchars($notification['recipient_phone']); ?></td>
                                        <td class="px-6 py-3"><?php echo htmlspecialchars($notification['message']); ?></td>
                                        <td class="px-2 py-3"><?php echo htmlspecialchars($notification['sent_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No notifications found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function searchTable() {
        const searchInput = document.getElementById('search-input').value.toLowerCase();
        const tableRows = document.querySelectorAll('#sms-table-body tr');

        tableRows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            if (rowText.includes(searchInput)) {
                row.style.display = ''; // Show matching rows
            } else {
                row.style.display = 'none'; // Hide non-matching rows
            }
        });
    }
</script>

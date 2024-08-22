<section class=" bg-violet-600 h-screen overflow-auto">
    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full rounded-lg overflow-x-hidden overflow-y-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">SMS Notification</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded ">
                <div class="flex justify-end p-2 text-white">

                    <div class="flex justify-end gap-2 items-center">
                        <button class="shadow rounded bg-green-500 px-2 py-1">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filter
                        </button>
                        <label for="search" class="text-black">Search</label>
                        <input name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-2 py-1" />
                    </div>
                </div>

                <div class="p-2 rounded-lg drop-shadow">
                    <table class="w-full">
                        <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">QR Code</th>
                                <th scope="col" class="px-2 py-3">Recipients</th>
                                <th scope="col" class="px-2 py-3">Send</th>
                                <th scope="col" class="px-6 py-3">Message</th>
                                <th scope="col" class="px-2 py-3">Date/Time</th>
                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 0; $i < 100; $i++){?>
                            <tr class="bg-white border-b text-xs text-center">
                                <td class="px-4 py-3"><?php echo $i?></td>
                                <td class="px-2 py-3">09123456789</td>
                                <td class="px-2 py-3">Dave</td>
                                <td class="px-6 py-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquam consequatur, unde molestiae porro veniam doloribus accusantium, in, tenetur ad repellat alias? Earum ratione soluta ex perspiciatis dolorum necessitatibus laudantium saepe.</td>
                                <td class="px-2 py-3">2023-10-10</td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</section>
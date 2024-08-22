<section class=" bg-violet-600 h-screen overflow-auto">
    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full rounded-lg overflow-x-hidden overflow-y-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Officer Account</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="h-96 bg-slate-100 rounded ">
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button class="shadow rounded bg-blue-500 px-2 py-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                    </div>
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
                                <th scope="col" class="px-2 py-3">#</th>
                                <th scope="col" class="px-2 py-3">Avatar</th>
                                <th scope="col" class="px-2 py-3">Last Name</th>
                                <th scope="col" class="px-2 py-3">First Name</th>
                                <th scope="col" class="px-2 py-3">Middle Name</th>
                                <th scope="col" class="px-2 py-3">Course/YL</th>
                                <th scope="col" class="px-1 py-3">Block</th>
                                <th scope="col" class="px-2 py-3">Username</th>
                                <th scope="col" class="px-2 py-3">Password</th>
                                <th scope="col" class="px-2 py-3">User Type</th>
                                <th scope="col" class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 0; $i < 100; $i++){?>
                            <tr class="bg-white border-b text-xs text-center">
                                <td class="px-2 py-3"><?php echo $i?></td>
                                <td class="px-2 py-3"><div class="rounded-full px-1 py-3 bg-slate-600 flex justify-center text-white"><i class="fa fa-users" aria-hidden="true"></i></div></td>
                                <td class="px-2 py-3">Gutierrez</td>
                                <td class="px-2 py-3">Dave</td>
                                <td class="px-2 py-3">Balagot</td>
                                <td class="px-2 py-3">BSIT-III</td>
                                <td class="px-1 py-3">A</td>
                                <td class="px-2 py-3">09123456789</td>
                                <td class="px-2 py-3">BSIT-III</td>
                                <td class="px-2 py-3">A</td>

                                <td class="px-6 py-3">
                                    <button class="text-xs rounded-full bg-red-600 hover:bg-red-500 px-2 py-1 text-white"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    <button class="text-xs rounded-full bg-blue-600 hover:bg-blue-500 px-2 py-1 text-white"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</section>
<section class=" bg-violet-600">
    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full h-screen rounded-lg overflow-x-hidden overflow-y-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Course List</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class=" bg-slate-100 rounded ">
                <div class="flex justify-between p-2 text-white">
                    <div>
                        <button data-modal-target="add-event-modal" data-modal-toggle="add-event-modal" class="shadow rounded bg-blue-500 px-2 py-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                    </div>
                    <div class="flex justify-end gap-2 items-center">
                        <button class="shadow rounded bg-green-500 px-2 py-1">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filter
                        </button>
                        <label for="search" class="text-black">Search</label>
                        <input name="search" type="search" placeholder="Search" class="text-black outline-none border border-slate-700 px-2 py-1" />
                    </div>
                </div>

                <div class="p-2 rounded-lg ">

                    <div class="grid grid-cols-4 gap-2">
                        <?php for($i = 0; $i < 10; $i++){?>
                        <div class="min-h-52 rounded-lg shadow p-2 relative">
                             <div class="w-full h-1/2 max-h-1/2 rounded-xl overflow-hidden">
                                <img src="https://archive.org/download/placeholder-image/placeholder-image.jpg" alt="" class="w-full h-full">

                             </div>

                             <div>
                                <h1 class="text-xl font-bold">Course Title</h1>
                                <p class="text-sm">Course Description</p>
                             </div>

                             <div class="absolute bottom-2 right-2 flex gap-2">
                                <button class="bg-blue-500 px-2 py-1 rounded text-white"><i class="fa fa-edit" aria-hidden="true"></i> </button>
                                <button class="bg-red-500 px-2 py-1 rounded text-white"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                             </div>

                             
                        </div>
                        <?php }?>
                    </div>
                  
                </div>
            </div>

        </div>
    </div>

</section>
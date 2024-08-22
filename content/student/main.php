<?php

require_once '../template/student-header.php'

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
                        <input type="text" name="password" id="password" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Search Event">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-gray-500">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-2 overflow-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php for ($i = 0; $i < 10; $i++) { ?>
                        <a href="index.php?view=event-details&id=<?php echo $i?>">

                            <div class="bg-white rounded drop-shadow px-4 hover:transform hover:scale-105 transition-transform duration-300">
                                <div class="border-s-4 border-cyan-900 h-full">
                                    <div class="p-1">
                                        <h1 class="text-xl font-bold">Event Name</h1>
                                        <h2 class="text-slate-500 text-xs">Date Here</h2>
                                        <p class="text-base"><span class="font-bold">Morning:</span> 8:00 am - 11:00 am</p>
                                        <p class="text-base"><span class="font-bold">Afternoon</span> 1:00 pm - 2:00 pm</p>

                                        <div class="text-end">
                                            <span class="text-green-500">On-going</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</section>
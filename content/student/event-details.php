<?php

require_once '../template/student-header.php'

?>

<section class="w-full  bg-violet-600">

    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full rounded-lg overflow-auto">
            <div class="pt-10 px-2">
                <hr class="h-2 bg-cyan-500">
            </div>

            <div class="text-center mt-2">
                <a href="index.php?view=scanner" class="rounded shadow-lg px-3 py-1 bg-cyan-500 text-white">Scan Qr</a>
            </div>

            <div class="flex justify-center items-center py-5 px-7 ">
                <div class="border drop-shadow shadow-xl rounded bg-slate-100 w-full p-2">
                    <div class="text-center mt-2">
                        <h1 class="text-2xl font-bold">IT - DAY</h1>
                    </div>

                    <div class="grid grid-cols-2 gap-5 ps-10 mt-10">
                        <div>
                            <h1 class="text-xl font-semibold">Event Title</h1>
                            <p class="text-lg ps-5">IT - DAY</p>
                        </div>

                        <div>
                            <h1 class="text-xl font-semibold">Event Start</h1>
                            <div class="flex">
                                <p class="text-lg ps-5">7:00 am</p>
                                <p class="text-lg ps-5">7:00 am</p>
                            </div>
                        </div>

                        <div>
                            <h1 class="text-xl font-semibold">Event Venue</h1>
                            <p class="text-lg ps-5">PCNL Field</p>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold">Event End</h1>
                            <div class="flex">
                                <p class="text-lg ps-5">7:00 am</p>
                                <p class="text-lg ps-5">7:00 am</p>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold">Event Description</h1>
                            <p class="text-lg ps-5">Wear your type a uniform</p>
                        </div>


                        <div>
                            <h1 class="text-xl font-semibold">Registration Cut-off Time:</h1>
                            <p class="text-lg ps-5">Date</p>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div class="flex justify-between p-2">
                    <div class="text-2xl font-bold ms-2">
                        Present Attendees
                    </div>
                    <div class="items-center">
                        <div class="relative">
                            <input type="text" name="password" id="password" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Search">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-gray-500">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-2">
                    <div class="grid grid-cols-5 gap-2">
                        <?php for ($i = 0; $i < 10; $i++) { ?>
                            <div class="border-2 border-slate-500 p-2 h-20">

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="grid grid-cols-5 gap-2">

                </div>
            </div>
        </div>

</section>
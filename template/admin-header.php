<nav class="w-full z-10 ">
    <div class=" mx-auto py-5 px-4 flex items-center justify-between w-full bg-violet-500">
        <div class="flex justify-between w-full items-center">
            <div class="flex justify-normal items-center text-white">
                <div class="mx-2">
                    <img src="../resource/img/logo.png" alt="" class="w-10">
                </div>
                <div class="w-3/4">
                    <span class="font-bold">Web-based event attendance monitoring system</span> - <?php
                                                                                                    echo $course['COURSE_NAME'] ?? "";
                                                                                                    ?>

                </div>
            </div>

            <div class="text-white ">
                <a href="../logout.php">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </a>
            </div>
        </div>

    </div>
</nav>
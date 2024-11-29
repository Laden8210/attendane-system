<nav class="w-full z-10 bg-violet-500 shadow-lg">
    <div class=" mx-auto py-4 px-6 flex items-center justify-between">
        <!-- Left Section: Logo and Title -->
        <div class="flex items-center text-white">
            <!-- Logo -->
            <div class="mr-3">
                <img src="../resource/img/logo.png" alt="Logo" class="w-12 h-12 ">
            </div>
            <!-- Title -->
            <div>
                <h1 class="text-lg sm:text-xl font-extrabold tracking-wide">
                    Web-based Event Attendance Monitoring System
                </h1>
                <p class="text-sm sm:text-base font-medium text-white/80">
                    Department: <?php echo $course['COURSE_NAME'] ?? "Not Assigned"; ?>
                </p>
            </div>
        </div>

        <!-- Right Section: Placeholder for Future Features -->
        <div class="text-white">
            <!-- Placeholder or Add Navigation Items Here -->
        </div>
    </div>
</nav>

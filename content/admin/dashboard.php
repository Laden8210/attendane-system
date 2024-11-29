<?php 
$events = $eventRepository->getEventByCourse($user['course_id']);
$officers = $officerRepository->getOfficersByCourse($user['course_id']);
$student  = $studentRepository->readByCourse($user['course_id']);

?>
<section class="bg-violet-600  flex items-center overflow-hidden">
    <div class="container mx-auto px-6 py-10">
        <!-- Dashboard Container -->
        <div class="bg-white rounded-lg shadow-lg">
            <!-- Header Section -->
            <div class="bg-cyan-500 text-white py-6 px-6">
                <h1 class="text-4xl font-bold text-center">Dashboard</h1>
            </div>
            <hr class="border-t-4 border-cyan-400">

            <!-- Stats Section -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 p-6">
                <!-- Card: Ongoing Events -->
                <div class="bg-green-600 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex justify-center items-center">
                            <i class="fa fa-calendar-check text-green-600 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Ongoing Events</h2>
                        </div>
                    </div>
                    <p class="text-4xl font-semibold text-right"><?php echo count($events) ?></p>
                </div>

                <!-- Card: Total Events -->
                <div class="bg-blue-700 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex justify-center items-center">
                            <i class="fa fa-calendar-alt text-blue-700 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Total Events</h2>
                        </div>
                    </div>
                    <p class="text-4xl font-semibold text-right"><?php echo count($events) ?></p>
                </div>

                <!-- Card: Officers -->
                <div class="bg-red-600 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-red-100 flex justify-center items-center">
                            <i class="fa fa-user-tie text-red-600 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Officers</h2>
                        </div>
                    </div>
                    <p class="text-4xl font-semibold text-right"><?php echo count($officers) ?></p>
                </div>

                <!-- Card: Students -->
                <div class="bg-pink-700 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-pink-100 flex justify-center items-center">
                            <i class="fa fa-users text-pink-700 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Students</h2>
                        </div>
                    </div>
                    <p class="text-4xl font-semibold text-right"><?php echo count($student) ?></p>
                </div>
            </div>

            <!-- School Name and Vision Section -->
            <div class="p-6 bg-gray-100">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">Philippine College of Northwestern Luzon</h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        "An Investment In Knowledge, Pays The Best Interest."
                    </p>
                    <p class="text-md text-gray-600 mt-4">
                        <i>Our Vision: To provide quality education that empowers individuals to achieve their fullest potential.</i>
                    </p>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="bg-gray-50 border-t border-gray-200 py-6">
                <div class="flex justify-center space-x-8">
                    <a href="#" class="text-blue-600 text-xl flex items-center space-x-2 hover:text-blue-800">
                        <i class="fa fa-facebook-official"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="#" class="text-red-600 text-xl flex items-center space-x-2 hover:text-red-800">
                        <i class="fa fa-youtube"></i>
                        <span>YouTube</span>
                    </a>
                    <a href="#" class="text-gray-600 text-xl flex items-center space-x-2 hover:text-gray-800">
                        <i class="fa fa-envelope"></i>
                        <span>Email</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

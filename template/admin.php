<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="resource/css/style.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/8d62d56333.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qr-creator/dist/qr-creator.min.js"></script>
    <link rel="stylesheet" href="@sweetalert2/theme-material-ui/material-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- Include DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <title><?php echo $title ?></title>
</head>

<body class="bg-violet-600 ">

    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-violet-400" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto  ">

            <div class="flex items-center p-4 bg-violet-600 rounded-lg shadow-md">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
                    <img src="../resource/uploads/<?php echo $user['avatar_file_path'] ?? 'default-avatar.png'; ?>" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div class="ms-3">
                    <p class="text-white text-lg font-bold">Admin</p>
                    <p class="text-white/70 text-sm">Administrator</p>
                </div>
            </div>
            <hr>
            <ul class="space-y-2 font-medium text-white mt-2">

                <li>
                    <a href="index.php" class="flex items-center p-2 rounded-lg hover:bg-violet-500 group <?php if ($title == 'Dashboard') {
                                                                                                                echo "bg-violet-500";
                                                                                                            } ?>">
                        <i class="fa fa-dashboard" aria-hidden="true"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?view=student-list" class="flex items-center p-2 rounded-lg hover:bg-violet-500 group <?php if ($title == 'Student List') {
                                                                                                                                echo "bg-violet-500";
                                                                                                                            } ?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Student List</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?view=event-list" class="flex items-center p-2  rounded-lg  hover:bg-violet-500 group <?php if ($title == 'Event') {
                                                                                                                                echo "bg-violet-500";
                                                                                                                            } ?>">
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Event</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?view=officer-list" class="flex items-center p-2  rounded-lg  hover:bg-violet-500 group <?php if ($title == 'Officer Account') {
                                                                                                                                    echo "bg-violet-500";
                                                                                                                                } ?>">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Officer Account</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?view=sms" class="flex items-center p-2 rounded-lg hover:bg-violet-500  group <?php if ($title == 'SMS Notification') {
                                                                                                                        echo "bg-violet-500";
                                                                                                                    } ?>">
                        <i class="fas fa-facebook-messenger"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">SMS Notification</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?view=report" class="flex items-center p-2 rounded-lg hover:bg-violet-500  group <?php if ($title == 'Report') {
                                                                                                                            echo "bg-violet-500";
                                                                                                                        } ?>">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Report</span>
                    </a>
                </li>



                <li>
                    <a href="../logout.php" class="flex items-center p-2 rounded-lg hover:bg-red-400  group">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <main class=" sm:ml-64 bg-violet-600 ">
        <?php
        require_once '../template/admin-header.php';
        require_once $content; ?>
    </main>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="../resource/js/script.js"></script>

</html>
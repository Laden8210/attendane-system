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
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="@sweetalert2/theme-material-ui/material-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js" integrity="sha512-is1ls2rgwpFZyixqKFEExPHVUUL+pPkBEPw47s/6NDQ4n1m6T/ySeDW3p54jp45z2EJ0RSOgilqee1WhtelXfA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title><?php echo $title ?></title>
</head>

<body class="bg-violet-600">

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-violet-500" aria-label="Sidebar">
    <div class="h-full px-4 py-6 overflow-y-auto">
        <!-- User Profile Section -->
        <div class="flex items-center p-4 bg-violet-600 rounded-lg shadow-md">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
                <img src="../resource/uploads/<?php echo $user['avatar_file_path'] ?? 'default-avatar.png'; ?>" alt="Avatar" class="w-full h-full object-cover">
            </div>
            <div class="ms-3">
                <p class="text-white text-lg font-bold">Admin</p>
                <p class="text-white/70 text-sm">Administrator</p>
            </div>
        </div>
        <hr class="my-4 border-gray-200">

        <!-- Navigation Links -->
        <ul class="space-y-2 font-medium text-white">
            <li>
                <a href="index.php" class="flex items-center p-2 rounded-lg hover:bg-violet-600 group <?php echo $title == 'Dashboard' ? 'bg-violet-600' : ''; ?>">
                    <i class="fa fa-dashboard text-lg"></i>
                    <span class="ms-3 text-sm font-semibold">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="index.php?view=admin-list" class="flex items-center p-2 rounded-lg hover:bg-violet-600 group <?php echo $title == 'Admin List' ? 'bg-violet-600' : ''; ?>">
                    <i class="fa fa-user text-lg"></i>
                    <span class="ms-3 text-sm font-semibold">Admin List</span>
                </a>
            </li>
            <li>
                <a href="index.php?view=course" class="flex items-center p-2 rounded-lg hover:bg-violet-600 group <?php echo $title == 'Course List' ? 'bg-violet-600' : ''; ?>">
                    <i class="fa fa-book text-lg"></i>
                    <span class="ms-3 text-sm font-semibold">Course List</span>
                </a>
            </li>
            <li>
                <a href="../logout.php" class="flex items-center p-2 rounded-lg hover:bg-red-500 group">
                    <i class="fa fa-sign-out text-lg"></i>
                    <span class="ms-3 text-sm font-semibold">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

    <main class=" sm:ml-64">
        <?php
        require_once '../template/admin-header.php';
        require_once $content; ?>
    </main>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
        // JavaScript to toggle the sidebar
        document.getElementById('burger-button').addEventListener('click', function() {
            const sidebar = document.getElementById('default-sidebar');
            sidebar.classList.toggle('-translate-x-full'); // Toggle the sidebar visibility
        });

        // Hide sidebar when clicking outside of it
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('default-sidebar');
            const burgerButton = document.getElementById('burger-button');

            // Check if the click was outside the sidebar and the burger button
            if (!sidebar.contains(event.target) && !burgerButton.contains(event.target)) {
                sidebar.classList.add('-translate-x-full'); // Hide the sidebar
            }
        });
    </script>

<script src="../resource/js/script.js"></script>

</html>
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
    <link rel="stylesheet" href="@sweetalert2/theme-material-ui/material-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js" integrity="sha512-is1ls2rgwpFZyixqKFEExPHVUUL+pPkBEPw47s/6NDQ4n1m6T/ySeDW3p54jp45z2EJ0RSOgilqee1WhtelXfA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title><?php echo $title ?></title>
</head>

<body>

    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-violet-400" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto  ">

            <div class="p-2 flex justify-start">
                <div class="rounded-full bg-slate-50 px-2 py-1">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <span class="ms-3 text-xl font-bold text-white">Super Admin</span>
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
                    <a href="index.php?view=admin-list" class="flex items-center p-2 rounded-lg hover:bg-violet-500 group <?php if ($title == 'Student List') {
                                                                                                                                echo "bg-violet-500";
                                                                                                                            } ?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Admin List</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?view=course" class="flex items-center p-2 rounded-lg hover:bg-violet-500 group <?php if ($title == 'Student List') {
                                                                                                                            echo "bg-violet-500";
                                                                                                                        } ?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Course List</span>
                    </a>
                </li>


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


<script src="../resource/js/script.js"></script>

</html>
<?php 

$courses = $courseRepository->getAllCourses();

if (count($courses) == 0) {
    echo "<script>window.location.href = 'index.php?view=login';</script>";
    return;
}

?>

<section class="w-screen h-screen flex items-center justify-center bg-gradient-to-r from-violet-500 to-violet-950">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 justify-center items-center">
        <?php

        $courses = $courseRepository->getAllCourses();

        $bgColors = ['bg-blue-700', 'bg-red-700', 'bg-green-700', 'bg-yellow-500', 'bg-purple-700', 'bg-pink-600'];

        foreach ($courses as $index => $course) {
            $courseImage = !empty($course['COURSE_IMAGE']) ? "resource/uploads/" . $course['COURSE_IMAGE'] : "https://via.placeholder.com/150";
            $courseTitle = $course['COURSE_NAME'];
            $courseId = $course['ID'];

            $bgColor = $bgColors[$index % count($bgColors)];
        ?>
            <a href="index.php?view=login&course_id=<?php echo $courseId; ?>"
               class="shadow rounded h-80 w-64 p-2 <?php echo $bgColor; ?> hover:transform hover:scale-110 transition-transform duration-300 flex flex-col items-center justify-between">
                <div class="card-header w-full">
                    <img src="<?php echo $courseImage; ?>" alt="course" class="w-full h-40 object-cover">
                </div>
                <div class="card-body w-full text-center">
                    <h1 class="text-xl font-bold text-white"><?php echo $courseTitle; ?></h1>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
</section>

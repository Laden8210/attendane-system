<?php 

$courses = $courseRepository->getAllCourses();

if (count($courses) == 0) {
    echo "<script>window.location.href = 'index.php?view=login';</script>";
    return;
}

?>
<section class="min-h-screen w-full flex flex-col items-center justify-center bg-gradient-to-r from-violet-500 to-violet-950 p-5">
    <!-- Note: Heading -->
    <div class="text-center mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white">Choose Your Department</h1>
        <p class="text-sm md:text-base text-gray-200 mt-2">Select your department to proceed to the login form</p>
    </div>

    <!-- Department Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-lg w-full">
        <?php
        foreach ($courses as $index => $course) {
            $courseImage = !empty($course['COURSE_IMAGE']) 
                ? "resource/uploads/" . $course['COURSE_IMAGE'] 
                : "https://via.placeholder.com/150";
            $courseTitle = $course['COURSE_NAME'];
            $courseId    = $course['ID'];
            $bgColor     = $course['COLOR'];
        ?>
            <a 
                href="index.php?view=login&course_id=<?php echo $courseId; ?>"
                style="background-color: <?php echo $bgColor; ?>;"
                class="shadow-lg border border-gray-200 rounded-lg p-4 
                       hover:transform hover:scale-105 transition-transform duration-300 
                       flex flex-col items-center justify-between 
                       w-full max-w-xs mx-auto"
            >
                <!-- Department Image -->
                <div class="card-header w-full mb-2">
                    <img 
                        src="<?php echo $courseImage; ?>" 
                        alt="course" 
                        class="w-full h-32 object-cover rounded-md"
                    >
                </div>
                
                <!-- Department Title -->
                <div class="card-body w-full text-center">
                    <h1 class="text-lg font-semibold text-white"><?php echo $courseTitle; ?></h1>
                    


                    <p class="text-white text-left mt-2 text-xs"><?php echo $course['DESCRIPTION']?></p>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
</section>

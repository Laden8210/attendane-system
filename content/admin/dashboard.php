<?php 
$events = $eventRepository->getEventByCourse($user['course_id']);
$officers = $officerRepository->getOfficersByCourse($user['course_id']);
$student  = $studentRepository->readByCourse($user['course_id']);

?>

<section class=" bg-violet-600">
    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full rounded-lg overflow-auto ">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <hr class="h-2 bg-cyan-500">
            </div>
            <div class="grid grid-cols-3 p-2 gap-2 ">
                <div class="grid grid-rows-4 p-2 gap-2">

                    <div class="rounded shadow-xl  bg-green-700  hover:transform hover:scale-95 transition-transform duration-300">
                        <div class="grid grid-cols-3 items-center p-2">
                            <div class="rounded-full w-20 h-20 bg-green-100"></div>
                            <div class="text-white p-2 col-span-2">
                                <h1 class="font-bold">On Going Event</h1>
                                <div class="text-end"><span><?php echo count($events)?></span></div>

                            </div>
                        </div>
                    </div>

                    <div class="rounded shadow-xl  bg-cyan-900  hover:transform hover:scale-95 transition-transform duration-300">
                        <div class="grid grid-cols-3 items-center p-2">
                            <div class="rounded-full w-20 h-20 bg-green-100"></div>
                            <div class="text-white p-2 col-span-2">
                                <h1 class="font-bold">Event</h1>
                                <div class="text-end"><span><?php echo count($events)?></span></div>

                            </div>
                        </div>
                    </div>

                    <div class="rounded shadow-xl  bg-red-400  hover:transform hover:scale-95 transition-transform duration-300">
                        <div class="grid grid-cols-3 items-center p-2">
                            <div class="rounded-full w-20 h-20 bg-green-100"></div>
                            <div class="text-white p-2 col-span-2">
                                <h1 class="font-bold">Officer Account</h1>
                                <div class="text-end"><span><?php echo count($officers)?></span></div>

                            </div>
                        </div>
                    </div>

                    <div class="rounded shadow-xl  bg-pink-700  hover:transform hover:scale-95 transition-transform duration-300">
                        <div class="grid grid-cols-3 items-center p-2">
                            <div class="rounded-full w-20 h-20 bg-green-100"></div>
                            <div class="text-white p-2 col-span-2">
                                <h1 class="font-bold">Student</h1>
                                <div class="text-end"><span><?php echo count($student)?></span></div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-span-2">
                    <div class="flex justify-start">
                        <div class="bg-slate-100 w-40 p-2 ">
                            <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIALcAwwMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABAUBAgMGB//EAC4QAQACAQIEBAQGAwAAAAAAAAABAgMEEQUhMVESEyJBUmFxkSNCgaHB0TIzkv/EABcBAQEBAQAAAAAAAAAAAAAAAAABAgP/xAAWEQEBAQAAAAAAAAAAAAAAAAAAARH/2gAMAwEAAhEDEQA/APoIDo5gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM+G3wz9gYAAAAAAAAAAAAAAAAAAAAB202nvqL+GnKI627A548d8t4pjrNrT7QstPwusbTntvPw16fdM0+DHp6eHHH1n3l1ZtakaY8OPF/rx1r9IdN2BFa3pTJG16Vt9Y3Rc3DcF+dN8c/LnH2TAFFqNFmwbzMeKnxVR3pULV8Ppl3ti2pft7S1KzYpx0vgy0tNbY7bx8mFRoAAAAREzMREbzPtAt+F6etMUZpje9uk9oKRAjRamY38mdvnMOF6Wpaa3rNZj2mHpEfW6euowzy9dY3rP8M61iiAaZAAAZpW17xSkb2mdogHTTYL6jLFKfrPaF7hxUw44pSNoj92mk09dNiisc7TztPeXZm1qQARQAAAAAAAHmgG2AABe8PvF9Jj2/LHhn9FE7abU5NNfenOJ61npKVYv2uW8Y8dr26VjdBjiuPbnivE9o2Q9XrL6n07eGkflj+UxdRgGmQABbcM0vl0868eu0emO0InDtN5+XxWj8OnX5z2XSWtSADKgAAAAAAAAAKu3Cr/lzVn612Rs2iz4udqbx3rzXoupjzQvdRo8OfeZr4b/FVVanSZdPO9o8VPa0LqYjgKgAAAA2x0tlyVpSN7WnaGq34ZpvLx+bePXaOXyhKsSsGKuDFXHXpHWe8ugMtAAAAAAAAAAAAAABMRMbTG8ACs1nDtt76ePrT+la9Kh63Q1z73x7VyftZZUsUwzatqWmtomLR1iWGmQEjR6W2pv2pH+VgdOHaXzr+ZePw6z/ANSuWKUrjpFKRtWOkMsWtyAAAAAAAAAAAAAAAAAAAAI+r0mPUxz9N46WhXW4bqInaPDaO8SuRdTFZg4XO++e0bfDX+1lSlcdYrSsVrHSIZE1cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAf/9k=" alt=""
                                class="rounded-full m-auto">
                        </div>
                        <div>
                            <h1 class="text-4xl font-semibold">Philippine College Of Northwestern Luzon</h1>
                        </div>
                    </div>

                    <div>
                        <h2>About</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iusto unde ducimus quo voluptas eos? Perspiciatis, reiciendis doloremque blanditiis aperiam laborum non praesentium veritatis et aliquid, repellat sunt animi voluptatibus qui.</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end my-2">
                <div class="grid grid-cols-3 gap-5">
                    <div class="text-xl">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
                        <span>Facebook</span>
                    </div>
                
                    <div class="text-xl">
                        <i class="fa fa-youtube" aria-hidden="true"></i>
                        <span>Youtube</span>
                    </div>

                    <div class="text-xl">
                    <i class="fa-regular fa-envelope"></i>
                        <span>Email</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
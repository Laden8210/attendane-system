<?php

require_once '../template/student-header.php'

?>

<section class="w-full h-screen bg-violet-600">

    <div class="w-full px-10 py-5">

        <div class="bg-slate-50 w-full rounded-lg overflow-auto h-full">

            <div class="pt-5 px-2 text-center">
                <h1 class="text-2xl font-bold">Student Information</h1>
                <hr class="h-2 bg-cyan-500">
            </div>

            <div class="p-10">
                <div class="grid grid-cols-3  m-auto gap-5">

                    <div class="bg-slate-100 p-2 rounded shadow-lg py-10">
                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIALcAwwMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABAUBAgMGB//EAC4QAQACAQIEBAQGAwAAAAAAAAABAgMEEQUhMVESEyJBUmFxkSNCgaHB0TIzkv/EABcBAQEBAQAAAAAAAAAAAAAAAAABAgP/xAAWEQEBAQAAAAAAAAAAAAAAAAAAARH/2gAMAwEAAhEDEQA/APoIDo5gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM+G3wz9gYAAAAAAAAAAAAAAAAAAAAB202nvqL+GnKI627A548d8t4pjrNrT7QstPwusbTntvPw16fdM0+DHp6eHHH1n3l1ZtakaY8OPF/rx1r9IdN2BFa3pTJG16Vt9Y3Rc3DcF+dN8c/LnH2TAFFqNFmwbzMeKnxVR3pULV8Ppl3ti2pft7S1KzYpx0vgy0tNbY7bx8mFRoAAAAREzMREbzPtAt+F6etMUZpje9uk9oKRAjRamY38mdvnMOF6Wpaa3rNZj2mHpEfW6euowzy9dY3rP8M61iiAaZAAAZpW17xSkb2mdogHTTYL6jLFKfrPaF7hxUw44pSNoj92mk09dNiisc7TztPeXZm1qQARQAAAAAAAHmgG2AABe8PvF9Jj2/LHhn9FE7abU5NNfenOJ61npKVYv2uW8Y8dr26VjdBjiuPbnivE9o2Q9XrL6n07eGkflj+UxdRgGmQABbcM0vl0868eu0emO0InDtN5+XxWj8OnX5z2XSWtSADKgAAAAAAAAAKu3Cr/lzVn612Rs2iz4udqbx3rzXoupjzQvdRo8OfeZr4b/FVVanSZdPO9o8VPa0LqYjgKgAAAA2x0tlyVpSN7WnaGq34ZpvLx+bePXaOXyhKsSsGKuDFXHXpHWe8ugMtAAAAAAAAAAAAAABMRMbTG8ACs1nDtt76ePrT+la9Kh63Q1z73x7VyftZZUsUwzatqWmtomLR1iWGmQEjR6W2pv2pH+VgdOHaXzr+ZePw6z/ANSuWKUrjpFKRtWOkMsWtyAAAAAAAAAAAAAAAAAAAAI+r0mPUxz9N46WhXW4bqInaPDaO8SuRdTFZg4XO++e0bfDX+1lSlcdYrSsVrHSIZE1cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAf/9k=" alt=""
                            class="rounded-full m-auto">
                    </div>


                    <div class="bg-slate-100 p-5 rounded shadow-lg col-span-2">
                        <div class="grid grid-rows-6 gap-2">
                            <div class="font-bold text-xl">Last Name: <span class="font-normal">Name</span></div>
                            <div class="font-bold text-xl">First Name: <span class="font-normal">Name</span></div>
                            <div class="font-bold text-xl">Middle Name: <span class="font-normal">Name</span></div>
                            <div class="font-bold text-xl">Year Level: <span class="font-normal">Name</span></div>
                            <div class="font-bold text-xl">Block: <span class="font-normal">Name</span></div>
                            <div class="font-bold text-xl">Guardian Phone No: <span class="font-normal">Name</span></div>

                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-2 gap-2">

                    <button class="bg-cyan-600 hover:bg-cyan-500 p-2 rounded shadow-lg text-white drop-shadow">Delete</button>

                    <button class="bg-cyan-600 hover:bg-cyan-500 p-2 rounded shadow-xl text-white">Confirm</button>

                </div>
            </div>



        </div>

</section>
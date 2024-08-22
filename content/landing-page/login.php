<section class="w-screen h-screen">
    <div class="w-screen h-screen flex  justify-center bg-violet-900">
        <div class="w-2/3 flex justify-center p-10">
            <div class="grid grid-cols-2">
                <div>
                    <div class="text-start">
                        <h1 class="text-4xl font-bold text-white">Web-based School event attendance monitoring System Login</h1>
                    </div>
                </div>
                <div class="">
                    <form action="index.php?view=login" method="post">
                        <div class="">

                            <div class="grid grid-cols-3 items-center mb-5">
                                <div class="text-end me-4">
                                    <label for="username" class="text-white"><i class="fas fa-user"></i></label>
                                </div>
                                <div class="col-span-2">
                                    <input type="text" name="username" id="username" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Email or Username">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 items-center mb-5">
                                <div class="text-end me-4">
                                    <label for="password " class="text-white"><i class="fas fa-unlock-alt"></i></label>
                                </div>
                                <div class="col-span-2 relative">
                                <input type="password" name="password" id="password" class="w-full p-2 outline-none rounded border border-gray-300" placeholder="Password">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-gray-500">
                                    <i id="toggleIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                </div>
                <div class="flex justify-end">
                    <div class="grid grid-rows-2 gap-5">
                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Login</button>
                        <a class="text-white" href="index.php?view=course">Admin <i class="fas fa-arrow-right"></i></a>
                    </div>

                </div>

            </div>
            </form>
        </div>
    </div>
    </div>

    </div>
</section>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="icon" type="image/png" href="../assets/img/logo.jpeg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins bg-white text-gray-900 ">  
    <nav class="bg-[#FEFEFE] shadow-lg px-[150px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="../assets/img/logo.png" class="w-auto h-12">
                    </div>
                </div>
                <div class="flex items-center space-x-4 font-semibold">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-[#FDD100]">Login</a>
                    <div class="bg-[#FDD100] rounded-sm">
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-white p-3">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-grey-600">
        <div class="flex justify-between items-center relative top-[80px] px-[150px]">
            <div class="text-left">
                <h1 class="text-4xl font-bold mb-3">
                    <span class="text-gray-800">Ruang untuk <br> Bersantai, </span> 
                    <span class="text-[#FDD100]"> Rasa <br> untuk Dinikmati</span>
                </h1>
                <a href="{{ route('login') }}" class="mt-3 text-xs text-white p-2 bg-[#FDD100] w-[90px] rounded-full hover:scale-105 hover:shadow-xl">Get Started!</a>
            </div>
            <div>
                <img src="../assets/img/image1.png" alt="Descriptive Alt Text" class="w-[300px] h-auto">
            </div>
        </div>
    </div>
</body>
</html>

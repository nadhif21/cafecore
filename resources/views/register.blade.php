<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/png" href="../assets/img/logo.jpeg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFD300]">
    <nav class="bg-[#FEFEFE] shadow-xl px-[150px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="../assets/img/logo.png" class="w-auto h-12" alt="Logo">
                    </div>
                </div>
                <div class="flex items-center space-x-4 font-semibold">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-[#FDD100]">Login</a>
                    <div class="bg-[#333333] rounded-sm">
                        <a href="{{ route('register') }}" class="text-[#FDD100] p-3">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-[#FFD300]">
        <div class="flex justify-between items-center relative top-[50px] px-[150px]">
            <div>
                <img src="../assets/img/image2.png" alt="Descriptive Alt Text" class="w-[300px] h-auto">
            </div>
            <div class="w-full max-w-md">
                <h2 class="text-center text-2xl font-bold text-white">Register</h2>
                <form method="POST" action="{{ route('register') }}" class="p-8">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-white">Name</label>
                        <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-white">Email</label>
                        <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-white">Password</label>
                        <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-white">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <button type="submit" class="w-full bg-[#333333] text-white py-2 rounded">Register</button>
                </form>
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-white">Sudah punya akun? Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

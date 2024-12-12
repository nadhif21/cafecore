<nav class="bg-[#FEFEFE] shadow-lg sticky top-0 z-10 px-[150px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <img src="../assets/img/logo.png" class="w-auto h-12">
                    admin
                </div>
            </div>
            <div class="flex items-center space-x-4 font-semibold">
                <a href="{{ route('admin.index') }}" class="text-gray-700 hover:text-[#FDD100]">
                    Confirm
                </a>
            <div class="flex items-center space-x-4 font-semibold">
                <a href="{{ route('upload') }}" class="text-gray-700 hover:text-[#FDD100]">
                    Upload
                </a>
                <div class="rounded-sm">
                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button type="submit" class="bg-[#FDD100] rounded text-white p-2  hover:bg-[#333333] hover:text-[#FDD100] transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

@yield('content')
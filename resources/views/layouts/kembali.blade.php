<nav class="bg-[#FEFEFE] shadow-lg sticky top-0 z-10 px-[150px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
            </div>
            <div class="flex items-center space-x-4 font-semibold">
                <a href="{{ route('user.catalog') }}" class="text-gray-700 hover:text-[#FDD100]">
                    &larr; Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</nav>
@yield('content')
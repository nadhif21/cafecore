<nav class="bg-[#FEFEFE] shadow-lg sticky top-0 z-10 px-[150px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <img src="../assets/img/logo.png" class="w-auto h-12">
                </div>
            </div>
            <div class="flex items-center space-x-4 font-semibold">
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-[#FDD100]">
                    Keranjang
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
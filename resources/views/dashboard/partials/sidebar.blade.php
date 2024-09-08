<div class="w-fit h-full bg-[#051951] text-white flex flex-col">
    <div class="flex items-center justify-center py-6 bg-[#051951]">
        <h1 class="text-3xl font-bold">TK ILMI</h1>
    </div>

    <nav class="flex-1">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.index') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.user.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.user.index') || request()->routeIs('dashboard.user.*') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Users
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.guru.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.guru.index') || request()->routeIs('dashboard.guru.*') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Guru
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.agama.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.agama.index') || request()->routeIs('dashboard.agama.*') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Agama
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.siswa.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.siswa.index') || request()->routeIs('dashboard.siswa.*') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Siswa
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.kategori.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.kategori.index') || request()->routeIs('dashboard.kategori.*') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Kategori Transaksi
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.transaksi.index') }}"
                   class="block py-3 px-4 text-sm font-medium text-white hover:bg-[#f18e00] {{ request()->routeIs('dashboard.transaksi.index') || request()->routeIs('dashboard.transaksi.*') ? 'bg-[#f18e00] text-[#051951]' : '' }}">
                    Transaksi
                </a>
            </li>
        </ul>
    </nav>

    <div class="py-6 px-4 border-t border-gray-700 bg-[#051951]">
        <div x-data="{ open: false }" class="relative flex flex-col items-center space-y-2">
            <div @click="open = !open" class="flex items-center space-x-3 cursor-pointer px-5">
                @php
                    $nameParts = explode(' ', trim(Auth::user()->name));
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                @endphp
                @if (Auth::user()->foto)
                    <img src="{{ Storage::url(Auth::user()->foto) }}" alt="User Photo" class="h-10 w-10 rounded-full object-cover">
                @else
                    <div class="bg-gray-300 h-10 w-10 rounded-full flex items-center justify-center text-xl font-bold text-gray-800">
                        {{ $initials }}
                    </div>
                @endif
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                </div>
                <button class="relative text-white">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div x-show="open"
                 x-transition:enter="transition-opacity ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="w-full mt-2 bg-white text-[#051951] shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-sm text-left bg-red-600 text-white hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

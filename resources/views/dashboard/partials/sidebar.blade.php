<div class="w-fit h-full bg-[#051951] text-white flex flex-col">
    <div class="flex items-center justify-center py-6 bg-[#051951] border-b border-[#f18e00]">
        <h1 class="text-3xl font-bold">TK ILMI</h1>
    </div>

    <nav class="flex-1">
        <ul class="space-y-2 p-4">
            @php
                $links = [
                    ['route' => 'dashboard.index', 'label' => 'Home'],
                    ['route' => 'dashboard.user.index', 'label' => 'Users'],
                    ['route' => 'dashboard.agama.index', 'label' => 'Agama'],
                    ['route' => 'dashboard.siswa.index', 'label' => 'Siswa'],
                    ['route' => 'dashboard.transaksi.index', 'label' => 'Transaksi'],
                    ['route' => 'dashboard.transaksi.check', 'label' => 'Cek Transaksi'],
                    ['route' => 'dashboard.kategori.index', 'label' => 'Kategori Transaksi'],
                ];
            @endphp

            @foreach ($links as $link)
                <li>
                    <a href="{{ route($link['route']) }}"
                       class="block py-3 px-4 text-sm font-medium rounded-lg transition-colors duration-300 hover:bg-[#f18e00] hover:text-[#051951] {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'*') ? 'bg-[#f18e00] text-[#051951]' : 'text-white' }}">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="py-6 px-4 border-t border-gray-700 bg-[#051951]">
        <div x-data="{ open: false }" class="relative flex flex-col items-center space-y-2">
            <div @click="open = !open" class="flex items-center space-x-3 cursor-pointer px-5 hover:bg-[#f18e00] hover:text-[#051951] rounded-lg transition-colors duration-300">
                @php
                    $nameParts = explode(' ', trim(Auth::user()->name));
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                @endphp
                @if (Auth::user()->foto)
                    <img src="{{ Storage::url(Auth::user()->foto) }}" alt="User Photo" class="h-10 w-10 rounded-full object-cover border-2 border-[#f18e00]">
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
                 class="w-full mt-2 bg-white text-[#051951] shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none rounded-lg">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard.update.profile', Auth::user()->email) }}" class="block w-full px-4 py-2 text-sm text-left hover:bg-gray-200 rounded-lg">
                            Profile
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-sm text-left bg-red-600 text-white hover:bg-red-700 rounded-lg">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

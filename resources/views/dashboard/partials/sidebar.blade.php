<div class="w-[300px] max-h-screen bg-[#051951] text-white flex flex-col">
    <div class="flex items-center justify-center py-6 bg-[#051951] border-b border-[#f18e00]">
        <h1 class="text-3xl font-bold">TK ILMI</h1>
    </div>

    <nav class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-[#f18e00] scrollbar-track-[#051951]">
        <ul class="space-y-2 p-4">
            @php
                $links = [];

                use App\Models\Siswa;
                use App\Models\Role;

                $user = Auth::user();
                $siswa = Siswa::where('user_id', $user->id)->first();
                $role = $user->role;

                if ($role->name === 'siswa') {
                    if ($siswa && $siswa->status === 'active') {
                        $links = [
                            ['route' => 'dashboard.transaksi.create', 'label' => 'Menu Pembayaran', 'icon' => 'fas fa-credit-card'],
                            ['route' => 'dashboard.transaksi.index', 'label' => 'Riwayat Pembayaran', 'icon' => 'fas fa-history'],
                            ['route' => 'dashboard.guru.show', 'label' => 'Daftar Pengajar', 'icon' => 'fas fa-chalkboard-teacher'],
                            ['route' => 'dashboard.programsemester.show', 'label' => 'Program Semester', 'icon' => 'fas fa-calendar'],
                            ['route' => 'dashboard.gallerykegiatan.show', 'label' => 'Gallery Kegiatan', 'icon' => 'fas fa-images'],
                        ];
                    } else {
                        $links[] = ['route' => 'dashboard.pendaftaran.index', 'label' => 'Pendaftaran', 'icon' => 'fas fa-user'];
                    }
                } else {
                    $links[] = ['route' => 'dashboard.index', 'label' => 'Home', 'icon' => 'fas fa-home'];

                    if ($role->permissions->contains('slug', 'read-users')) {
                        $links[] = ['route' => 'dashboard.user.index', 'label' => 'Data Users', 'icon' => 'fas fa-users'];
                    }
                    if ($role->permissions->contains('slug', 'read-roles')) {
                        $links[] = ['route' => 'dashboard.roles.index', 'label' => 'Data Role', 'icon' => 'fas fa-shield'];
                    }
                    if ($role->permissions->contains('slug', 'read-siswa')) {
                        $links[] = ['route' => 'dashboard.siswa.index', 'label' => 'Data Siswa', 'icon' => 'fas fa-user-graduate'];
                    }
                    if ($role->permissions->contains('slug', 'read-guru')) {
                        $links[] = ['route' => 'dashboard.guru.index', 'label' => 'Data Pengajar', 'icon' => 'fas fa-chalkboard-teacher'];
                    }
                    if ($role->permissions->contains('slug', 'read-tahunajaran')) {
                        $links[] = ['route' => 'dashboard.tahunajaran.index', 'label' => 'Tahun Ajaran', 'icon' => 'fas fa-calendar-alt'];
                    }
                    if ($role->permissions->contains('slug', 'read-programsemester')) {
                        $links[] = ['route' => 'dashboard.programsemester.index', 'label' => 'Data Program Semester', 'icon' => 'fas fa-calendar'];
                    }
                    if ($role->permissions->contains('slug', 'read-gallerykegiatan')) {
                        $links[] = ['route' => 'dashboard.gallerykegiatan.index', 'label' => 'Data Gallery Kegiatan', 'icon' => 'fas fa-images'];
                    }
                    if ($role->permissions->contains('slug', 'read-kategori_transaksi')) {
                        $links[] = ['route' => 'dashboard.kategori.index', 'label' => 'Data Kategori Transaksi', 'icon' => 'fas fa-list'];
                    }
                    if ($role->permissions->contains('slug', 'read-transaksi')) {
                        $links[] = ['route' => 'dashboard.transaksi.check', 'label' => 'Cari Transaksi', 'icon' => 'fas fa-search'];
                        $links[] = ['route' => 'dashboard.transaksi.index', 'label' => 'Data Transaksi', 'icon' => 'fas fa-credit-card'];
                    }
                }
            @endphp

            @foreach ($links as $link)
                <li>
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center py-3 px-4 text-sm font-medium rounded-lg transition-colors duration-300 hover:bg-[#f18e00] hover:text-[#051951] {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'*') ? 'bg-[#f18e00] text-[#051951]' : 'text-white' }}">
                        <i class="{{ $link['icon'] }} mr-2"></i>
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="py-6 px-4 border-t border-gray-700 bg-[#051951]">
        <div x-data="{ open: false }" class="relative flex flex-col items-center space-y-2">
            <div @click="open = !open" class="flex items-center space-x-3 cursor-pointer px-3 hover:bg-[#f18e00] hover:text-[#051951] rounded-lg transition-colors duration-300 py-3">
                @php
                    $nameParts = explode(' ', trim($user->name));
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                @endphp
                @if ($user->foto)
                    <img src="{{ Storage::url($user->foto) }}" alt="User Photo" class="h-10 w-10 rounded-full object-cover border-2 border-[#f18e00]">
                @else
                    <div class="bg-gray-300 h-10 w-10 rounded-full flex items-center justify-center text-xl font-bold text-gray-800">
                        {{ $initials }}
                    </div>
                @endif
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
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
                        <a href="{{ route('dashboard.update.profile', $user->email) }}" class="block w-full px-4 py-2 text-sm text-left hover:bg-gray-200 rounded-lg">
                            <i class="fas fa-user-circle mr-2"></i>Profile
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-sm text-left bg-red-600 text-white hover:bg-red-700 rounded-lg">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

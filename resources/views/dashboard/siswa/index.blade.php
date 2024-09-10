@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">{{ $title }}</h1>

    <div class="mb-4">
        <a href="{{ route('dashboard.siswa.create') }}" class="bg-[#f18e00] text-white px-4 py-2 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out">
            Add New Siswa
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-md">
        <table class="w-full min-w-full divide-y divide-gray-200">
            <thead class="bg-[#051951] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">User ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tempat Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Agama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Foto Akte Kelahiran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Orang Tua</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Alamat Orang Tua</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data as $siswa)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $siswa->user->id }} - {{ $siswa->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->alamat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->tempat_lahir }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->tanggal_lahir }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->agama->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($siswa->foto_akte_kelahiran)
                                <img src="{{ Storage::url($siswa->foto_akte_kelahiran) }}" alt="Foto Akte Kelahiran" class="w-16 h-16 object-cover">
                            @else
                                <span class="text-gray-400">No Photo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->nama_orang_tua }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->alamat_orang_tua }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('dashboard.siswa.edit', $siswa->id) }}" class="text-[#f18e00] hover:text-[#d77900]">Edit</a>
                            <form action="{{ route('dashboard.siswa.delete', $siswa->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800 ml-4" onclick="confirmDelete(event, this.form)">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

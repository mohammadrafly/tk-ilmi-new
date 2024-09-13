@extends('layouts.dashboard')

@section('content')
    @include('components.swal')

    @include('components.message')

    <div class="bg-white p-8 w-full mx-auto">
        <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Lengkapi Pendaftaran</div>
        <hr class="mb-6">

        <form method="POST" action="{{ route('dashboard.pendaftaran.index', ) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="alamat" class="block text-sm font-medium text-[#051951]">Alamat</label>
                <div class="mt-2">
                    <input id="alamat" type="text" name="alamat" value="{{ old('alamat', $siswa->alamat ?? '') }}"
                           class="w-full border {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Address" required>
                    @error('alamat')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="tempat_lahir" class="block text-sm font-medium text-[#051951]">Tempat Lahir</label>
                <div class="mt-2">
                    <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                           class="w-full border {{ $errors->has('tempat_lahir') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Birthplace" required>
                    @error('tempat_lahir')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="tanggal_lahir" class="block text-sm font-medium text-[#051951]">Tanggal Lahir</label>
                <div class="mt-2">
                    <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                           class="w-full border {{ $errors->has('tanggal_lahir') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Date of Birth" required>
                    @error('tanggal_lahir')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="agama_id" class="block text-sm font-medium text-[#051951]">Agama</label>
                <div class="mt-2">
                    <select id="agama_id" name="agama_id" class="w-full border {{ $errors->has('agama_id') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                        <option value="">Select Religion</option>
                        @foreach ($agamas as $agama)
                            <option value="{{ $agama->id }}" {{ old('agama_id', $siswa->agama_id) == $agama->id ? 'selected' : '' }}>
                                {{ $agama->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('agama_id')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="foto_akte_kelahiran" class="block text-sm font-medium text-[#051951]">Foto Akte Kelahiran</label>
                <div class="mt-2">
                    <input id="foto_akte_kelahiran" type="file" name="foto_akte_kelahiran"
                           class="w-full border {{ $errors->has('foto_akte_kelahiran') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                    @error('foto_akte_kelahiran')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="nama_orang_tua" class="block text-sm font-medium text-[#051951]">Nama Orang Tua</label>
                <div class="mt-2">
                    <input id="nama_orang_tua" type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $siswa->nama_orang_tua ?? '') }}"
                           class="w-full border {{ $errors->has('nama_orang_tua') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Parent's Name" required>
                    @error('nama_orang_tua')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="alamat_orang_tua" class="block text-sm font-medium text-[#051951]">Alamat Orang Tua</label>
                <div class="mt-2">
                    <input id="alamat_orang_tua" type="text" name="alamat_orang_tua" value="{{ old('alamat_orang_tua', $siswa->alamat_orang_tua ?? '') }}"
                           class="w-full border {{ $errors->has('alamat_orang_tua') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Parent's Address" required>
                    @error('alamat_orang_tua')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                    Lanjutkan
                </button>
            </div>
        </form>
    </div>
@endsection

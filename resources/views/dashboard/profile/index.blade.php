@extends('layouts.dashboard')

@section('content')

<div class="p-5 w-full mx-auto">
    <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Profile</div>
    <hr class="mb-6">
        <form method="POST" action="{{ route('dashboard.update.profile', $data->email) }}" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6">
            @csrf
            @method('PUT')

            <div class="w-full md:w-1/3">
                <div class="text-center bg-white p-6 shadow rounded-md">
                    <label for="foto" class="block text-sm font-medium text-[#051951]">Profile Photo</label>
                    <div class="mt-2">
                        @if($data->foto)
                            <img src="{{ Storage::url($data->foto) }}" alt="Profile Photo" class="h-64 w-64 object-cover rounded-full mx-auto">
                        @else
                            @php
                                $nameParts = explode(' ', trim(Auth::user()->name));
                                $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                            @endphp
                            <div class="h-64 w-64 bg-gray-300 text-white flex items-center justify-center rounded-full mx-auto">
                                <span class="text-6xl font-bold">
                                    {{ $initials }}
                                </span>
                            </div>
                        @endif
                        <input id="foto" type="file" name="foto"
                               class="w-full border {{ $errors->has('foto') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent mt-4">
                        @error('foto')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3">
                <div class="w-full bg-white p-6 shadow rounded-md">
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-[#051951]">Name</label>
                        <div class="mt-2">
                            <input id="name" type="text" name="name" value="{{ $data->name }}"
                                   class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                                   placeholder="Enter Name" required>
                            @error('name')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-[#051951]">Email</label>
                        <div class="mt-2">
                            <input id="email" type="email" name="email" value="{{ $data->email }}"
                                   class="w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                                   placeholder="Enter Email" required>
                            @error('email')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-[#051951]">Role</label>
                        <div class="mt-2">
                            <select id="role" name="role"
                                    class="w-full border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                                    disabled>
                                <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="siswa" {{ $data->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="jk" class="block text-sm font-medium text-[#051951]">Gender</label>
                        <div class="mt-2">
                            <select id="jk" name="jk"
                                    class="w-full border {{ $errors->has('jk') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                                    required>
                                <option value="male" {{ $data->jk == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $data->jk == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('jk')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                            Update Profile
                        </button>
                    </div>
                </div>
            </div>
        </form>

    @if($data->role == 'siswa')
    <hr class="my-8">

    <div class="bg-white mt-8 p-6 shadow rounded-md">
        <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Siswa Details</div>

        <form method="POST" action="{{ route('dashboard.update.siswa', $data->siswa->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="alamat" class="block text-sm font-medium text-[#051951]">Address</label>
                <div class="mt-2">
                    <input id="alamat" type="text" name="alamat" value="{{ $data->siswa->alamat }}"
                           class="w-full border {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Address" required>
                    @error('alamat')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="tempat_lahir" class="block text-sm font-medium text-[#051951]">Place of Birth</label>
                <div class="mt-2">
                    <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ $data->siswa->tempat_lahir }}"
                           class="w-full border {{ $errors->has('tempat_lahir') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Place of Birth" required>
                    @error('tempat_lahir')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="tanggal_lahir" class="block text-sm font-medium text-[#051951]">Date of Birth</label>
                <div class="mt-2">
                    <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ $data->siswa->tanggal_lahir }}"
                           class="w-full border {{ $errors->has('tanggal_lahir') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           required>
                    @error('tanggal_lahir')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="agama_id" class="block text-sm font-medium text-[#051951]">Religion</label>
                <div class="mt-2">
                    <select id="agama_id" name="agama_id"
                            class="w-full border {{ $errors->has('agama_id') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                            required>
                        @foreach($agama as $item)
                            <option value="{{ $item->id }}" {{ $data->siswa->agama_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('agama_id')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="foto_akte_kelahiran" class="block text-sm font-medium text-[#051951]">Birth Certificate Photo</label>
                <div class="mt-2">
                    @if($data->siswa->foto_akte_kelahiran)
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard.siswa.view_certificate', $data->siswa->id) }}"
                               class="text-blue-500 hover:underline" target="_blank">View Birth Certificate</a>
                        </div>
                    @else
                        <input id="foto_akte_kelahiran" type="file" name="foto_akte_kelahiran"
                               class="w-full border {{ $errors->has('foto_akte_kelahiran') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent">
                    @endif
                    @error('foto_akte_kelahiran')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="nama_orang_tua" class="block text-sm font-medium text-[#051951]">Parent's Name</label>
                <div class="mt-2">
                    <input id="nama_orang_tua" type="text" name="nama_orang_tua" value="{{ $data->siswa->nama_orang_tua }}"
                           class="w-full border {{ $errors->has('nama_orang_tua') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Parent's Name" required>
                    @error('nama_orang_tua')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="alamat_orang_tua" class="block text-sm font-medium text-[#051951]">Parent's Address</label>
                <div class="mt-2">
                    <input id="alamat_orang_tua" type="text" name="alamat_orang_tua" value="{{ $data->siswa->alamat_orang_tua }}"
                           class="w-full border {{ $errors->has('alamat_orang_tua') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Parent's Address" required>
                    @error('alamat_orang_tua')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                    Update Siswa Details
                </button>
            </div>
        </form>
    </div>
    @endif

    <hr class="my-8">

    <div class="bg-white mt-8 p-6 shadow rounded-md">
        <div class="text-2xl font-bold mb-6 text-center text-[#051951]">Change Password</div>

        <div class="mb-6 text-sm text-gray-600">
            <p class="font-semibold">Password Requirements:</p>
            <ul class="list-disc ml-5 mt-2">
                <li>At least 8 characters long</li>
                <li>Includes at least one uppercase letter (A-Z)</li>
                <li>Includes at least one number (0-9)</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('dashboard.update.password', $data->email) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="current_password" class="block text-sm font-medium text-[#051951]">Current Password</label>
                <div class="mt-2">
                    <input id="current_password" type="password" name="current_password"
                           class="w-full border {{ $errors->has('current_password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter Current Password" required>
                    @error('current_password')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-[#051951]">New Password</label>
                <div class="mt-2">
                    <input id="password" type="password" name="password"
                           class="w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Enter New Password" required>
                    @error('password')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-[#051951]">Confirm New Password</label>
                <div class="mt-2">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="w-full border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }} shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent"
                           placeholder="Confirm New Password" required>
                    @error('password_confirmation')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00] rounded-md">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>

@include('components.swal')

@endsection

@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-extrabold text-[#051951] mb-8">Select Payment Options</h1>

    <div class="bg-white p-8 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-bold text-[#f18e00] mb-6">Choose Your Payment Method and Type</h2>

        <form action="{{ route('dashboard.pendaftaran.processPaymentOptions') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="metode" class="block text-lg font-bold text-[#051951] mb-2">Metode Pembayaran</label>
                <select name="metode" id="metode" class="shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent" required>
                    <option value="" disabled selected>Pilih metode pembayaran</option>
                    @foreach ($metodeOptions as $metode)
                        <option value="{{ $metode }}">{{ ucfirst($metode) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="jenis" class="block text-lg font-bold text-[#051951] mb-2">Jenis Pembayaran</label>
                <select name="jenis" id="jenis" class="shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent" required>
                    <option value="" disabled selected>Pilih jenis pembayaran</option>
                    @foreach ($jenisOptions as $jenis)
                        <option value="{{ $jenis }}">{{ ucfirst($jenis) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="bg-[#051951] text-white px-6 py-3 rounded-lg shadow-lg hover:bg-[#041836] transition duration-300 ease-in-out font-semibold">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

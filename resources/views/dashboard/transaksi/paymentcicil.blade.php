@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-extrabold text-[#051951] mb-8">Upload Payment Proof</h1>

    <div class="bg-white p-8 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-bold text-[#f18e00] mb-6">Transaction Code: {{ $transaksi->kode }}</h2>
        <p class="mb-6 text-gray-600">Please upload your payment proof to complete the transaction.</p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.transaksi.pay.cicil', $transaksi->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="bukti_pembayaran" class="block text-sm font-semibold text-gray-700">Upload Payment Proof:</label>
                <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="mt-2 p-2 border border-gray-300 rounded-lg w-full" required>
            </div>

            <button type="submit" class="bg-[#f18e00] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#d77900] transition duration-300 ease-in-out font-semibold">
                Submit Payment Proof
            </button>
        </form>
    </div>

    <a href="{{ route('dashboard.transaksi.index') }}" class="inline-block bg-[#f18e00] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#d77900] transition duration-300 ease-in-out font-semibold">
        Back to List
    </a>
</div>

@endsection

@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-[#051951] mb-6">{{ $title }}</h1>

    <form id="payment-form" method="POST" action="{{ route('dashboard.transaksi.check') }}">
        @csrf
        <div class="mb-6">
            <label for="kode" class="block text-sm font-medium text-[#051951]">Kode Transaksi</label>
            <input type="text" id="kode" name="kode" class="w-full border border-gray-300 shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent" required>
        </div>

        <div class="text-center mt-6">
            <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00]">
                Cari Transaksi
            </button>
        </div>
    </form>

    @if (isset($payments))
        <div class="mt-6">
            <div class="bg-white p-5 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Payment Details</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#051951] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->kode }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->metode }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->status == '0' ? 'Belum Lunas' : 'Lunas' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('dashboard.transaksi.check.detail', ['kode' => $payment->kode]) }}" class="text-blue-600 hover:text-blue-800">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif (isset($error))
        <div class="mt-6 text-red-500">
            {{ $error }}
        </div>
    @endif
</div>

@endsection

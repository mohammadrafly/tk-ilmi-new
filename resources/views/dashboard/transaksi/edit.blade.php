@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-extrabold text-[#051951] mb-8">Transaction Details</h1>

    <div class="bg-white p-8 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-bold text-[#f18e00] mb-6">Transaction Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-2">
                <div class="text-lg"><strong class="text-[#051951]">Kode:</strong> <span class="text-gray-800 text-xl font-bold">{{ $transaksi->kode }}</span></div>
                <div class="text-lg"><strong class="text-[#051951]">User:</strong> <span class="text-gray-800">{{ $transaksi->user->name }}</span></div>
            </div>
            <div class="space-y-2">
                <div class="text-lg"><strong class="text-[#051951]">Metode:</strong> <span class="text-gray-800">{{ ucfirst($transaksi->metode) }}</span></div>
                <div class="text-lg"><strong class="text-[#051951]">Jenis:</strong> <span class="text-gray-800">{{ ucfirst($transaksi->jenis) }}</span></div>
                <div class="text-lg">
                    <strong class="text-[#051951]">Status:</strong>
                    <span class="px-2 py-1 rounded-lg {{ $transaksi->status === 'completed' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        {{ ucfirst($transaksi->status == '0' ? 'Belum Lunas' : 'Cicil') }}
                    </span>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-semibold text-[#051951] mb-4">Transaction Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-[#051951] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Harga</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($listTransaksi as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->kategori->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($item->harga, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-100">
                    <tr>
                        <td class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Total</td>
                        <td class="px-6 py-3 text-left text-sm font-semibold text-gray-900">{{ number_format($totalHarga, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($transaksi->jenis === 'cicil')
            <h3 class="text-xl font-semibold text-[#051951] mt-8 mb-4">Installment Details</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-[#051951] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Bulan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Cicilan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Expired</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($listCicilTransaksi as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Month {{ $item->bulan }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($item->cicilan, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item->expired }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $item->status === 'lunas' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        {{ ucfirst($item->status == 'belum_lunas' ? 'Belum Lunas' : 'Lunas') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status !== 'lunas')
                                        @if($transaksi->metode === 'cash')
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600">For cash payments, please visit the TU office with the following transaction code:</p>
                                                <p class="text-lg font-bold text-[#051951]">{{ $transaksi->kode }}</p>
                                                <ul class="list-disc list-inside text-left text-gray-600 mt-2">
                                                    <li>Visit the TU office during office hours.</li>
                                                    <li>Provide your transaction code: <strong class="text-[#051951]">{{ $transaksi->kode }}</strong>.</li>
                                                    <li>Complete the payment with the cash amount specified for this installment.</li>
                                                    <li>Keep the receipt for your records.</li>
                                                </ul>
                                            </div>
                                        @else
                                            <a href="{{ route('dashboard.transaksi.pay.cicil', $item->id) }}" class="bg-[#f18e00] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#d77900] transition duration-300 ease-in-out font-semibold">
                                                Upload Payment Proof
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @if($transaksi->metode === 'cash')
                <div class="mt-8 text-center">
                    <p class="text-lg font-semibold text-gray-800 mb-4">For cash payments, please visit the TU office with the following transaction code:</p>
                    <p class="text-2xl font-bold text-[#051951]">{{ $transaksi->kode }}</p>
                    <p class="text-sm text-gray-600 mt-4">Instructions for cash payment:</p>
                    <ul class="list-disc list-inside text-left text-gray-600">
                        <li>Visit the TU office during office hours.</li>
                        <li>Provide your transaction code: <strong class="text-[#051951]">{{ $transaksi->kode }}</strong>.</li>
                        <li>Complete the payment with the cash amount specified.</li>
                        <li>Keep the receipt for your records.</li>
                    </ul>
                </div>
            @else
                @if($transaksi->status !== '2')
                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard.transaksi.pay', $transaksi->id) }}" class="bg-[#f18e00] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#d77900] transition duration-300 ease-in-out font-semibold">
                            Upload Payment Proof
                        </a>
                    </div>
                @endif
            @endif
        @endif
    </div>

    <a href="{{ route('dashboard.transaksi.index') }}" class="inline-block bg-[#f18e00] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#d77900] transition duration-300 ease-in-out font-semibold">
        Back to List
    </a>
</div>

@endsection

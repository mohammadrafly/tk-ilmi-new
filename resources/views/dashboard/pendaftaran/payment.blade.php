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
                    <span class="px-2 py-1 rounded-lg {{ $transaksi->status === '2' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        {{ ucfirst($transaksi->status == '0' ? 'Belum Lunas' : 'Lunas') }}
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
        @if($transaksi->status !== '2')
            @if ($transaksi->metode === 'online')
                <div class="mt-4 text-center">
                    <button id="payButton" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out font-semibold">
                        Pay Now
                    </button>
                </div>
            @else
                <div class="mt-8 bg-yellow-100 p-6 rounded-lg border border-yellow-300 shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-yellow-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.953 7.93l-3.853 3.853a.76.76 0 0 0 0 1.065l3.853 3.853a.76.76 0 0 0 1.065 0l3.853-3.853a.76.76 0 0 0 0-1.065l-3.853-3.853a.76.76 0 0 0-1.065 0z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-[#051951]">Payment Instructions</h3>
                    </div>
                    <p class="text-gray-800 mb-4">Please make your payment in cash at the TU (Tata Usaha) office using the following transaction code:</p>
                    <p class="text-lg font-bold text-[#051951]">Kode: <span class="text-gray-800">{{ $transaksi->kode }}</span></p>
                    <p class="mt-2">Ensure you bring this code with you to help us process your payment smoothly.</p>
                </div>
            @endif
        @endif
    </div>
</div>

@endsection


@section('script')
<script>
    $(document).ready(function() {
        $('#payButton').click(function() {
            handlePayment();
        });

        function handlePayment() {
            $.ajax({
                url: '{{ route('api.payment.penuh', $transaksi->kode) }}',
                method: 'POST',
                success: function(response) {
                    window.snap.pay(response, {
                        onSuccess: function(result) {
                            console.log('Payment Success', result);
                            updatePaymentStatus(result);
                        },
                        onPending: function(result) {
                            alert("Payment pending!"); console.log(result);
                        },
                        onError: function(result) {
                            alert("Payment failed!"); console.log(result);
                        },
                        onClose: function() {
                            alert('Payment pop-up closed without finishing the payment');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function updatePaymentStatus(result) {
            $.ajax({
                url: '{{ route('api.callback.pendaftaran', $transaksi->kode )}}',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: result,
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
</script>
@endsection

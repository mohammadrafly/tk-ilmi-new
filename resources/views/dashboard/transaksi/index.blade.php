@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-[#051951] mb-6">{{ $title }}</h1>

    <div class="mb-6">
        <form action="{{ route('dashboard.transaksi.download') }}" method="GET" class="flex items-center">
            <label for="from_date" class="mr-2">Start Date:</label>
            <input type="date" name="from_date" id="from_date" class="border border-gray-300 px-2 py-1 rounded mr-4">

            <label for="to_date" class="mr-2">End Date:</label>
            <input type="date" name="to_date" id="to_date" class="border border-gray-300 px-2 py-1 rounded mr-4">

            <button type="submit" class="bg-[#051951] text-white px-4 py-2 rounded hover:bg-[#034ea2] transition duration-300">Download XLSX</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-2">
        <table id="transaksiTable" class="w-full min-w-full divide-y divide-gray-200">
            <thead class="bg-[#051951] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Metode</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jenis</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data as $transaksi)
                    <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaksi->kode }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $transaksi->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($transaksi->metode) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($transaksi->jenis) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($transaksi->status == 0)
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">Belum Lunas</span>
                            @elseif($transaksi->status == 1)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">Cicil</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Lunas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('dashboard.transaksi.show', $transaksi->kode) }}" class="text-[#f18e00] hover:text-[#d77900] transition duration-300 ease-in-out">View</a>
                            @if (Auth::user()->role === 'admin')
                            <form action="{{ route('dashboard.transaksi.delete', $transaksi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800 ml-4 transition duration-300 ease-in-out" onclick="confirmDelete(event, this.form)">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')

<script>
    function confirmDelete(event, form) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this transaction?')) {
            form.submit();
        }
    }

    $(document).ready(function() {
        $('#transaksiTable').DataTable({
            "pageLength": 10,
            "order": [[0, 'desc']],
            "language": {
                "search": "Search transactions:"
            }
        });
    });
</script>

@endsection

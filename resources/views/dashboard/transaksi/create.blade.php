@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-[#051951] mb-6">{{ $title }}</h1>

    <form method="POST" action="{{ route('dashboard.transaksi.create') }}">
        @csrf

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-md mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-5 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Pilih Pembayaran</h2>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($kategori as $item)
                        <div class="border border-gray-200 p-4 rounded-lg flex items-center justify-between shadow-sm hover:shadow-lg transition-shadow duration-300 ease-in-out">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-[#051951]">{{ $item->nama }}</h3>
                                <p class="text-sm text-gray-600">Rp {{ number_format($item->harga, 2) }}</p>
                            </div>
                            <button type="button" class="bg-[#f18e00] text-white px-4 py-2 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out pilih-kategori" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" data-price="{{ $item->harga }}">
                                Pilih
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-5 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Rincian Pembayaran</h2>
                <div class="bg-white shadow-md rounded-md">
                    <table class="w-full min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#051951] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="selected-categories" class="bg-white divide-y divide-gray-200">
                        </tbody>
                        <tfoot class="bg-[#051951] text-white">
                            <tr>
                                <td class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Total Harga</td>
                                <td class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" id="total-harga">0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mb-6 mt-5">
                    <label for="metode" class="block text-sm font-medium text-[#051951]">Metode</label>
                    <select id="metode" name="metode" class="w-full border border-gray-300 shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent" required>
                        <option value="cash">Cash</option>
                        <option value="online">Online</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="jenis" class="block text-sm font-medium text-[#051951]">Jenis</label>
                    <select id="jenis" name="jenis" class="w-full border border-gray-300 shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent" required>
                        <option value="penuh">Penuh</option>
                        <option value="cicil">Cicil</option>
                    </select>
                </div>

                <div id="bulan-field" class="mb-6 hidden">
                    <label for="bulan" class="block text-sm font-medium text-[#051951]">Jumlah Bulan</label>
                    <input type="number" id="bulan" name="bulan" class="w-full border border-gray-300 shadow-sm px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f18e00] focus:border-transparent" min="1" value="1">
                </div>

                <div id="selected-kategori-ids"></div>

                <div class="text-center mt-6">
                    <button type="submit" class="w-full bg-[#f18e00] text-white font-semibold py-3 rounded-md hover:bg-[#d77900] transition duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f18e00]">
                        Create Transaksi
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('jenis');
        const bulanField = document.getElementById('bulan-field');
        const selectedCategoriesTable = document.getElementById('selected-categories');
        const totalHargaElement = document.getElementById('total-harga');
        const selectedKategoriIdsDiv = document.getElementById('selected-kategori-ids');
        let selectedCategories = [];
        let totalHarga = 0;

        jenisSelect.addEventListener('change', function() {
            bulanField.classList.toggle('hidden', this.value !== 'cicil');
        });

        document.querySelectorAll('.pilih-kategori').forEach(button => {
            button.addEventListener('click', function() {
                const kategoriId = this.getAttribute('data-id');
                const kategoriName = this.getAttribute('data-name');
                const kategoriPrice = parseFloat(this.getAttribute('data-price'));

                if (selectedCategories.find(item => item.id === kategoriId)) {
                    alert('Kategori ini sudah dipilih.');
                    return;
                }

                selectedCategories.push({ id: kategoriId, name: kategoriName, price: kategoriPrice });
                totalHarga += kategoriPrice;

                updateSelectedCategories();
                totalHargaElement.textContent = totalHarga.toLocaleString('id-ID', { minimumFractionDigits: 2 });
                updateSelectedKategoriIds();
                updateJenisField();
            });
        });

        function updateSelectedCategories() {
            selectedCategoriesTable.innerHTML = '';
            selectedCategories.forEach((category, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${category.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp ${category.price.toLocaleString('id-ID', { minimumFractionDigits: 2 })}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                        <button type="button" class="remove-kategori" data-index="${index}">Remove</button>
                    </td>
                `;
                selectedCategoriesTable.appendChild(row);
            });

            document.querySelectorAll('.remove-kategori').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));

                    totalHarga -= selectedCategories[index].price;
                    selectedCategories.splice(index, 1);

                    updateSelectedCategories();
                    totalHargaElement.textContent = totalHarga.toLocaleString('id-ID', { minimumFractionDigits: 2 });
                    updateSelectedKategoriIds();
                    updateJenisField();
                });
            });
        }

        function updateSelectedKategoriIds() {
            selectedKategoriIdsDiv.innerHTML = '';
            selectedCategories.forEach(category => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'kategori_ids[]';
                input.value = category.id;
                selectedKategoriIdsDiv.appendChild(input);
            });
        }

        function updateJenisField() {
            const isSppOnly = selectedCategories.length === 1 && selectedCategories[0].name === 'SPP';
            const cicilOption = jenisSelect.querySelector('option[value="cicil"]');
            if (isSppOnly) {
                jenisSelect.value = 'penuh';
                if (cicilOption) {
                    cicilOption.remove();
                }
            } else {
                if (!cicilOption && selectedCategories.length > 1) {
                    const option = document.createElement('option');
                    option.value = 'cicil';
                    option.textContent = 'Cicil';
                    jenisSelect.appendChild(option);
                }
            }
        }
    });
</script>

@include('components.swal')

@endsection

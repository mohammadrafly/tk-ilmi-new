@extends('layouts.dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-[#051951] mb-4">{{ $title }}</h1>

    @include('components.message')

    <div class="overflow-x-auto bg-white shadow-md rounded-md">
        @foreach($data->groupBy('tahunajaran_id') as $tahunajaranId => $programSemestersByTahun)
            @php
                $tahunajaran = $programSemestersByTahun->first()->tahunajaran;
            @endphp

            <h2 class="text-xl font-semibold mb-2 p-3">
               Tahun Ajaran {{ $tahunajaran->tahunawal }} - {{ $tahunajaran->tahunakhir }}
            </h2>

            @foreach($programSemestersByTahun->groupBy('semester') as $semester => $programSemestersBySemester)
                <h3 class="text-lg font-semibold mb-2 px-3">
                    Semester {{ $semester == 1 ? '1' : '2' }}
                </h3>

                <table class="w-full min-w-full divide-y divide-gray-200 mb-6">
                    <thead class="bg-[#051951] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bulan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Topik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Minggu 1</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Minggu 2</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Minggu 3</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Minggu 4</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($programSemestersBySemester as $programsemester)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $programsemester->bulan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $programsemester->topik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $programsemester->minggu1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $programsemester->minggu2 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $programsemester->minggu3 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $programsemester->minggu4 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endforeach
    </div>
</div>

@include('components.swal')

@endsection

@extends('super.master-layout')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(16, 185, 129, 0.05);
        transition: background-color 0.3s ease;
    }
</style>
@endsection

@section('title', 'List Pekerjaan')

@section('content')
@include('super.SidebarAdmin')


<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    <!-- Search and Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex-1 max-w-lg">
            <form action="{{ route('master.pekerjaan.listpekerjaan') }}" method="GET" class="flex space-x-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by kode pekerjaan"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500">
                </div>
                
                <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-colors">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-600 table-hover">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Kode Pekerjaan</th>
                    <th class="px-6 py-3">Nama Pekerjaan</th>
                    <th class="px-6 py-3">Jam Pekerjaan (menit)</th>
                    <th class="px-6 py-3">Limit Pekerja</th>
                    <th class="px-6 py-3">Penanggung Jawab</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataPekerjaan as $nomor => $pekerjaan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $pekerjaan['kode_pekerjaan'] }}
                    </td>
                    <td class="px-6 py-4">{{ $pekerjaan['nama_pekerjaan'] }}</td>
                    <td class="px-6 py-4">{{ $pekerjaan['jam_pekerjaan'] }}</td>
                    <td class="px-6 py-4">
                        {{ max(0, $pekerjaan['batas_pekerja']) }}
                    </td>
                    <td class="px-6 py-4">{{ $pekerjaan['penanggung_jawab'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Tidak ada data pekerjaan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
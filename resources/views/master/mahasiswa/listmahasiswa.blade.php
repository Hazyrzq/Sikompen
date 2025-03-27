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

@section('title', 'List Mahasiswa')

@section('content')
@include('super.SidebarAdmin')

<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    <!-- Import dan Action Buttons -->
    <div class="flex justify-between items-center mb-6 gap-4">
        <!-- Import Form -->
        <div class="flex-1">
            <form id="importForm" action="{{ route('master.mahasiswa.import.proses') }}" method="POST" enctype="multipart/form-data" class="flex space-x-3">
                @csrf
                <div class="relative flex-1">
                    <input type="file" name="excel_file" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                </div>
                <button id="importButton" type="button" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center">
                    <i class="fas fa-file-import mr-2"></i> Import Data
                </button>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <a href="{{ route('master.mahasiswa.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Data
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-600 table-hover">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">NIM</th>
                    <th class="px-6 py-3">Nama Mahasiswa</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Kelas</th>
                    <th class="px-6 py-3">Semester</th>
                    <th class="px-6 py-3">Prodi</th>
                    <th class="px-6 py-3">Jumlah Terlambat (Menit)</th>
                    <th class="px-6 py-3">Jumlah Alfa (Menit)</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalData = count($dataMahasiswa);
                @endphp
                @foreach ($dataMahasiswa as $nomor => $value)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $totalData - $nomor }}</td>
                    <td class="px-6 py-4">{{ $value['kode_user'] }}</td>
                    <td class="px-6 py-4">{{ $value['nama_user'] }}</td>
                    <td class="px-6 py-4">{{ $value['email'] }}</td>
                    <td class="px-6 py-4">{{ $value['kelas'] }}</td>
                    <td class="px-6 py-4">{{ $value['semester'] }}</td>
                    <td class="px-6 py-4">{{ $value['prodi'] }}</td>
                    <td class="px-6 py-4">{{ $value['jumlah_terlambat'] }}</td>
                    <td class="px-6 py-4">{{ $value['jumlah_alfa'] }}</td>
                    <td class="px-6 py-4">{{ $value['total'] }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a href="{{ route('master.mahasiswa.edit', ['id_mahasiswa' => $value->id_mahasiswa]) }}" 
                               class="inline-flex items-center px-3 py-1 border border-emerald-500 text-emerald-600 rounded-md hover:bg-emerald-50 transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <a href="{{ route('mahasiswa.delete.proses', ['id_mahasiswa' => $value['id_mahasiswa']]) }}" 
                               class="inline-flex items-center px-3 py-1 border border-red-500 text-red-600 rounded-md hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if(count($dataMahasiswa) === 0)
                <tr>
                    <td colspan="11" class="px-6 py-4 text-center text-gray-500">Tidak ada data mahasiswa</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js-content')
<script>
    // Add your JavaScript here if needed
</script>

@if (Session::has('alert-success'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: '{{ Session::get('alert-success') }}'
    });
</script>
@endif
@if (Session::has('alert-error'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'error',
        title: '{{ Session::get('alert-error') }}'
    });
</script>
@endif
@endsection
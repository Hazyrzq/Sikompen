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

@section('title', 'List Kelas')

@section('content')
@include('super.SidebarAdmin')

<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    <!-- Import and Add Button -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="w-full md:w-1/2">
            <form action="{{ route('master.kelas.import') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-lg shadow-md">
                @csrf
                <div class="mb-3">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Import Data Kelas dari Excel:</label>
                    <div class="flex space-x-2">
                        <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-300 rounded-lg" id="file" name="file" required>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                            Import
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('master.kelas.create') }}" class="flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Tambah Data
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800">List Kelas</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 table-hover">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Kelas</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalData = count($dataKelas);
                    @endphp
                    @foreach ($dataKelas as $nomor => $value)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $totalData - $nomor }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $value['kelas'] }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('master.kelas.edit', ['id_kelas' => $value->id_kelas]) }}" class="text-amber-600 hover:text-amber-800 mx-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button class="text-red-600 hover:text-red-800 mx-1" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $value->id_kelas }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>

                    
                    <!-- End Modal Konfirmasi Hapus -->
                    @endforeach

                    @if(count($dataKelas) == 0)
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">
                            Tidak ada data kelas
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        $('#table-utama').DataTable({
            dom: 'Bfrtip',
            order: [0, 'desc'] // Sort by the first column (No)
        });
    });
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
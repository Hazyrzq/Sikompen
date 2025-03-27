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

@section('title', 'List User')

@section('content')
@include('super.SidebarAdmin')

<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    <!-- Search and Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex-1 max-w-lg">
            <form action="{{ route('master.user.listuser') }}" method="GET" class="flex space-x-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by NIP or Email..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500">
                </div>
                
                <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-colors">
                    Search
                </button>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <a href="{{ route('master.user.create') }}" 
               class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center">
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
                    <th class="px-6 py-3">Nama User</th>
                    <th class="px-6 py-3">NIP</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalData = count($dataUser);
                @endphp
                @foreach ($dataUser as $nomor => $value)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $totalData - $nomor }}</td>
                    <td class="px-6 py-4">{{ $value['nama_user'] }}</td>
                    <td class="px-6 py-4">{{ $value['kode_user'] }}</td>
                    <td class="px-6 py-4">{{ $value['email'] }}</td>
                    <td class="px-6 py-4">{{ $value['role'] }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('master.user.edit', ['id_user' => $value->id_user]) }}" 
                           class="inline-flex items-center px-3 py-1 border border-emerald-500 text-emerald-600 rounded-md hover:bg-emerald-50 transition-colors duration-200">
                            <i class="fas fa-edit mr-1"></i>
                            Edit
                        </a>
                        <button data-bs-toggle="modal" data-bs-target="#alertConfirm{{ $value['id_user'] }}"
                                class="inline-flex items-center px-3 py-1 border border-red-500 text-red-600 rounded-md hover:bg-red-50 transition-colors duration-200">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        $('#table-utama').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ],
            order: [0, 'asc']
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
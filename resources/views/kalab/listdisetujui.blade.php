@extends('super.master-layout')

@section('title', 'List Disetujui Kepala Lab')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
    }
    
    .hidden-column {
        display: none;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(16, 185, 129, 0.05);
        transition: background-color 0.3s ease;
    }
    
    /* Tabs di bagian atas */
    .nav-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background-color: white;
        border-radius: 0.5rem 0.5rem 0 0;
        padding: 0 1rem;
    }
    
    .nav-tab {
        position: relative;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        border-bottom: 2px solid transparent;
        color: #4b5563;
    }
    
    .nav-tab.active {
        color: #059669;
        border-bottom: 2px solid #059669;
        background-color: #f0fdf4;
    }
    
    .nav-tab:not(.active):hover {
        color: #059669;
        border-bottom: 2px solid #10b981;
    }
    
    .nav-tab i {
        margin-right: 0.5rem;
    }
    
    /* Mengatur margin konten agar sesuai dengan sidebar */
    #mainContent {
        margin-left: 4rem !important;
        transition: margin-left 0.3s ease;
    }
    
    /* Animasi untuk tabel */
    .content-appear {
        opacity: 0;
        transform: translateY(10px);
        animation: contentAppear 0.5s forwards;
    }
    
    @keyframes contentAppear {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Status badges */
    .status-badge {
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    
    .status-approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
</style>
@endsection

@section('content')
<!-- Include sidebar -->
@include('super.SidebarKalab')

<!-- Content - PENTING: Tambahkan id mainContent di sini -->
<div id="mainContent" class="transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 mt-4">
        <!-- Tabs Navigation -->
        
        
        </div>

        <!-- Search and Actions -->
        <div class="flex justify-between items-center mb-6 content-appear" style="animation-delay: 0.1s">
            <div class="flex-1 max-w-lg">
                <form method="GET" action="{{ route('kalab.listdisetujui') }}" class="flex space-x-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by nama, status..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        Search
                    </button>
                    @if(request('search'))
                    <a href="{{ route('kalab.listdisetujui') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Clear
                    </a>
                    @endif
                </form>
            </div>
            <div class="flex space-x-3">
                <button id="export-pdf" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Download PDF Report
                </button>
            </div>
        </div>

        @if (Session::has('alert-success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 content-appear" style="animation-delay: 0.2s" role="alert">
            {{ Session::get('alert-success') }}
        </div>
        @endif

        @if (Session::has('alert-error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 content-appear" style="animation-delay: 0.2s" role="alert">
            {{ Session::get('alert-error') }}
        </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto content-appear" style="animation-delay: 0.3s">
            <table id="table-utama" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total (Menit)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa (Menit)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 3</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval 3 By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($dataPengajuan as $index => $pengajuan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->id_pengajuan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->kode_kegiatan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->nama_user }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->total }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->sisa }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="status-badge {{ $pengajuan->status_approval1 == 'Disetujui' ? 'status-approved' : 'status-pending' }}">
                                {{ $pengajuan->status_approval1 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="status-badge {{ $pengajuan->status_approval2 == 'Disetujui' ? 'status-approved' : 'status-pending' }}">
                                {{ $pengajuan->status_approval2 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="status-badge {{ $pengajuan->status_approval3 == 'Disetujui' ? 'status-approved' : 'status-pending' }}">
                                {{ $pengajuan->status_approval3 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->approval3_by }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                           
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($dataPengajuan) === 0)
                    <tr>
                        <td colspan="11" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengajuan yang disetujui</td>
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
        // Initialize DataTables on the table
        var table = $('#table-utama').DataTable({
            dom: 'lBfrtip', // B for buttons
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'bg-green-600 text-white rounded hover:bg-green-700 px-3 py-2 text-sm',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-600 text-white rounded hover:bg-red-700 px-3 py-2 text-sm ml-2',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-blue-600 text-white rounded hover:bg-blue-700 px-3 py-2 text-sm ml-2',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
        
        // PDF Export button click handler
        $('#export-pdf').click(function() {
            table.button('.buttons-pdf').trigger();
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
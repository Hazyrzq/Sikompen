@extends('super.master-layout')

@section('title', 'List Pekerjaan')

@section('css-content')
<link href="assets/css/main_DaftarPengajuan.css" rel="stylesheet">
@endsection

@section('content')
@include('super.SidebarPlp')
<div class="container mx-auto px-4 sm:px-6 mt-6">
    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6">
            <!-- Search and Actions -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex-1 max-w-lg">
                    <form method="GET" class="flex space-x-3">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                placeholder="Search by nama, status approval..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                            Search
                        </button>
                    </form>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.location.href='Export_pdf.php'"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                        <i class="fas fa-download mr-2"></i>
                        Download PDF Report
                    </button>
                </div>
            </div>

            @if (Session::has('success_message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ Session::get('success_message') }}
                </div>
            @endif

            @if (Session::has('error_message'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ Session::get('error_message') }}
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pengajuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Kegiatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total (Menit)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa (Menit)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 1 (Pengawas)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 2 (PLP)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 3 (KaLab)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($dataPengajuan as $index => $pengajuan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->id_pengajuan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->kode_kegiatan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->nama_user }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->total }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->sisa }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->status_approval1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->status_approval2 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->status_approval3 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        // Initialize DataTable with custom options
        $('#table-utama').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>

@if (Session::has('alert-success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ Session::get('alert-success') }}',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if (Session::has('alert-error'))
<script>
    Swal.fire({
        icon: 'error',
        title: '{{ Session::get('alert-error') }}',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif
@endsection

@section('css-content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection
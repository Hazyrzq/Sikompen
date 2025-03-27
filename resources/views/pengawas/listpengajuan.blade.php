@extends('super.master-layout')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .hidden-column {
        display: none;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(16, 185, 129, 0.05);
        transition: background-color 0.3s ease;
    }
</style>
@endsection

@section('title', 'Daftar Pengajuan')

@section('content')
@include('super.SidebarPengawas')

<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    
    <!-- Filter Form -->
    <div class="bg-white shadow-md rounded-lg mb-6 p-4">
        <form method="GET" action="{{ route('pengawas.listpengajuan') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[150px]">
                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas:</label>
                <select id="kelas" name="kelas" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-emerald-500">
                    <option value="">All</option>
                    @foreach ($kelasOptions as $kelasOption)
                    <option value="{{ $kelasOption->kelas }}" {{ $selectedKelas == $kelasOption->kelas ? 'selected' : '' }}>
                        {{ $kelasOption->kelas }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[150px]">
                <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester:</label>
                <select id="semester" name="semester" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-emerald-500">
                    <option value="">All</option>
                    @foreach ($semesterOptions as $semesterOption)
                    <option value="{{ $semesterOption->semester }}" {{ $selectedSemester == $semesterOption->semester ? 'selected' : '' }}>
                        {{ $semesterOption->semester }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Search and Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex-1 max-w-lg">
            <form method="GET" action="{{ route('pengawas.listpengajuan') }}" class="flex space-x-3">
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
            </form>
        </div>
    </div>

    @if (Session::has('alert-success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ Session::get('alert-success') }}
    </div>
    @endif

    @if (Session::has('alert-error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ Session::get('alert-error') }}
    </div>
    @endif

    <!-- Table -->
    <form id="approveForm" action="{{ route('pengawas.approve-selected') }}" method="POST">
        @csrf
        <div class="mb-4">
            <button type="button" id="checkAllBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-check mr-2"></i> Centang Semua
            </button>
            <button type="button" id="approveSelectedBtn" class="ml-3 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <i class="fas fa-check-circle mr-2"></i> Setujui Terpilih
            </button>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total (Menit)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa (Menit)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 3</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span class="sr-only">Select</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($dataPengajuan as $index => $pengajuan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->id_pengajuan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->kode_kegiatan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->nama_user }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->kelas }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->semester }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->total }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->sisa }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->status_approval1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->status_approval2 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengajuan->status_approval3 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($pengajuan->status_approval1 == 'Disetujui')
                            <button disabled class="inline-flex items-center px-3 py-1 border border-gray-300 bg-gray-100 text-gray-600 rounded-md cursor-not-allowed">
                                <i class="fas fa-eye mr-1"></i> Teruskan
                            </button>
                            @elseif ($pengajuan->status_approval1 == 'Pending')
                            <button disabled class="inline-flex items-center px-3 py-1 border border-yellow-300 bg-yellow-100 text-yellow-600 rounded-md cursor-not-allowed">
                                <i class="fas fa-clock mr-1"></i> Menunggu
                            </button>
                            @else
                            <a href="{{ route('pengawas.edit', ['kode_kegiatan' => $pengajuan->kode_kegiatan]) }}" 
                               class="inline-flex items-center px-3 py-1 border border-emerald-500 text-emerald-600 rounded-md hover:bg-emerald-50 transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i> Teruskan
                            </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <input type="checkbox" name="selected_pengajuan[]" value="{{ $pengajuan->id_pengajuan }}" 
                                   class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($dataPengajuan) === 0)
                    <tr>
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengajuan</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </form>
</div>
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        // Initialize DataTables on the table
        $('#table-utama').DataTable({
            dom: 'lfrtip',
            order: [0, 'asc'] // Sort by the first column (No)
        });

        // Script to handle approve selected button click
        $('#approveSelectedBtn').click(function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menyetujui pengajuan yang dipilih!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Setujui!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.getElementById('approveForm').submit();
                }
            });
        });

        // Script to handle check all button click
        $('#checkAllBtn').click(function() {
            var isChecked = $(this).hasClass('active');
            $('input[name="selected_pengajuan[]"]').prop('checked', !isChecked);
            $(this).toggleClass('active');
            if (!isChecked) {
                $(this).html('<i class="fas fa-times mr-2"></i> Batal Centang Semua');
                $(this).removeClass('bg-blue-600 hover:bg-blue-700').addClass('bg-red-600 hover:bg-red-700');
            } else {
                $(this).html('<i class="fas fa-check mr-2"></i> Centang Semua');
                $(this).removeClass('bg-red-600 hover:bg-red-700').addClass('bg-blue-600 hover:bg-blue-700');
            }
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
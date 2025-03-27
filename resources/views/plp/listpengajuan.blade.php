@extends('super.master-layout')

@section('title', 'Daftar Pengajuan')

@section('css-content')
<link href="assets/css/main_DaftarPengajuan.css" rel="stylesheet">
<link href="assets/css/submit_modal.css" rel="stylesheet">
<link href="assets/css/process_modal.css" rel="stylesheet">
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
                    <button type="button" onclick="submitSemuaPengajuan()" 
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Semua Pengajuan
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
                <form id="submission-form" method="POST" action="{{ route('plp.approveSelected') }}">
                    @csrf
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Table Header -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="check-all" onclick="toggleAllCheckboxes(this)"
                                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    <label for="check-all" class="ml-2">Pilih Semua</label>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Kegiatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total (Menit)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa (Menit)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 1 (PENGAWAS)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 2 (PLP)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Approval 3 (KALAB)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($dataPengajuan as $index => $pengajuan)
                                <tr>
                                    <!-- Kolom Checkbox -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" id="check{{ $index }}" name="selected_pengajuan[]"
                                            value="{{ $pengajuan->id_pengajuan }}"
                                            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        <label for="check{{ $index }}"></label>
                                    </td>

                                    <!-- Kolom No -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">{{ $index + 1 }}</span>
                                    </td>

                                    <!-- Data Columns -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->id_pengajuan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->kode_kegiatan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->nama_user }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->total }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->sisa }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->status_approval1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->status_approval2 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengajuan->status_approval3 }}
                                    </td>

                                    <!-- Kolom Aksi -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('plp.edit', ['kode_kegiatan' => $pengajuan->kode_kegiatan]) }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                            <i class="fas fa-check mr-2"></i>
                                            Setujui
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk detail pengajuan -->
<div id="modalDetail" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full">
            <!-- Header Modal -->
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Detail Pengajuan</h3>
                <button onclick="tutupModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Isi Modal -->
            <div class="p-4">
                <div id="detailContent"></div>
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
            dom: 'lfrtip',
            order: [1, 'asc']
        });

        // Handle "check all" checkbox
        $('#check-all').change(function() {
            var checkboxes = $('input[name="selected_pengajuan[]"]');
            checkboxes.prop('checked', $(this).prop('checked'));
        });
    });

    function toggleAllCheckboxes(source) {
        var checkboxes = document.getElementsByName('selected_pengajuan[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    function approvePengajuan(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menyetujui pengajuan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('plp.approveSelected') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        selected_pengajuan: [id]
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyetujui pengajuan.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    function submitSemuaPengajuan() {
        var selectedPengajuan = [];
        $("input[name='selected_pengajuan[]']:checked").each(function () {
            selectedPengajuan.push($(this).val());
        });

        if (selectedPengajuan.length > 0) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin menyetujui semua pengajuan yang dipilih?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('plp.approveSelected') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            selected_pengajuan: selectedPengajuan
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menyetujui pengajuan.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Pengajuan',
                text: 'Pilih setidaknya satu pengajuan untuk disetujui.',
                confirmButtonText: 'OK'
            });
        }
    }

    function tutupModal() {
        document.getElementById('modalDetail').classList.add('hidden');
    }
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
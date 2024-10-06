@extends('super.master-layout')

@section('title', 'Daftar Semua Pengajuan')

@section('content')
<div class="container-fluid mt-4">

    <div class="row mb-3">
        <div class="col-12">
            <div class="card radius-15">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">Daftar Semua Pengajuan</h4>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="filter-class">Kelas:</label>
                            <select id="filter-class" class="form-control select2">
                                <option value="">Semua</option>
                                @foreach ($kelasOptions as $kelas)
                                <option value="{{ $kelas }}">{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-prodi">Program Studi:</label>
                            <select id="filter-prodi" class="form-control select2">
                                <option value="">Semua</option>
                                @foreach ($prodiOptions as $prodi)
                                <option value="{{ $prodi }}">{{ $prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-semester">Semester:</label>
                            <select id="filter-semester" class="form-control select2">
                                <option value="">Semua</option>
                                @foreach ($semesterOptions as $semester)
                                <option value="{{ $semester }}">{{ $semester }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-year">Tahun:</label>
                            <select id="filter-year" class="form-control select2">
                                <option value="">Semua</option>
                                @foreach ($yearOptions as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-kompen">Status Kompen:</label>
                            <select id="filter-kompen" class="form-control select2">
                                <option value="">Semua</option>
                                <option value="Kompen">Kompen</option>
                                <option value="Tidak Kompen">Tidak Kompen</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button id="filter-button" class="btn btn-primary mr-2">Filter</button>
                            <button id="clear-filter-button" class="btn btn-secondary">Clear</button>
                        </div>
                    </div>

                    <!-- Table of Pengajuan -->
                    <div class="table-responsive">
                        <table id="table-utama" class="table table-sm table-striped table-bordered table-hover"
                            style="width:100%">
                            <thead class="th-dark">
                                <tr>
                                    <th>No</th>
                                    <th>ID Pengajuan</th>
                                    <th>Kode Kegiatan</th>
                                    <th>Nama User</th>
                                    <th>Kelas</th>
                                    <th>Semester</th>
                                    <th>Total(Menit)</th>
                                    <th>Sisa (Menit)</th>
                                    <th>Status Approval 1</th>
                                    <th>Status Approval 2</th>
                                    <th>Status Approval 3</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPengajuan as $index => $pengajuan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pengajuan->id_pengajuan }}</td>
                                    <td>{{ $pengajuan->kode_kegiatan }}</td>
                                    <td>{{ $pengajuan->nama_user }}</td>
                                    <td>{{ $pengajuan->kelas }}</td>
                                    <td>{{ $pengajuan->semester }}</td>
                                    <td>{{ $pengajuan->total }}</td>
                                    <td>{{ $pengajuan->sisa }}</td>
                                    <td>{{ $pengajuan->status_approval1 }}</td>
                                    <td>{{ $pengajuan->status_approval2 }}</td>
                                    <td>{{ $pengajuan->status_approval3 }}</td>
                                    <td>
                                        @if ($pengajuan->total == 0)
                                        Tidak Kompen
                                        @elseif ($pengajuan->total > 0)
                                        Kompen
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('dospem.lihatdetail', ['kode_kegiatan' => $pengajuan->kode_kegiatan]) }}">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();

        var table = $('#table-utama').DataTable({
            dom: 'lBfrtip', // Include buttons in the DOM
            buttons: [
                'excel', // Add Excel button
                {
                    extend: 'pdf', // Add PDF button
                    exportOptions: {
                        columns: [2, 3, 4, 5, 7, 11, 12, 13] // Specify columns to include in PDF
                    }
                },
                {
                    extend: 'print', // Add Print button
                    autoPrint: true,
                    exportOptions: {
                        columns: [2, 3, 4, 5, 7, 11, 12, 13] // Specify columns to include in print
                    }
                }
            ],
            order: [0, 'asc'], // Sort by the first column (No)
            initComplete: function() {
                // Optionally populate class and prodi filter options dynamically here
            }
        });

        $('#filter-button').on('click', function() {
            var classFilter = $('#filter-class').val();
            var prodiFilter = $('#filter-prodi').val();
            var semesterFilter = $('#filter-semester').val();
            var yearFilter = $('#filter-year').val();
            var kompenFilter = $('#filter-kompen').val();

            if (classFilter) {
                table.columns(4).search('^' + classFilter + '$', true, false); // Exact match for class using regex
            } else {
                table.columns(4).search(''); // Clear filter if no value
            }

            if (prodiFilter) {
                table.columns(5).search('^' + prodiFilter + '$', true, false); // Exact match for program of study using regex
            } else {
                table.columns(5).search(''); // Clear filter if no value
            }

            if (semesterFilter) {
                table.columns(6).search('^' + semesterFilter + '$', true, false); // Exact match for semester using regex
            } else {
                table.columns(6).search(''); // Clear filter if no value
            }

            if (yearFilter) {
                table.columns(7).search('^' + yearFilter + '$', true, false); // Exact match for year using regex
            } else {
                table.columns(7).search(''); // Clear filter if no value
            }

            if (kompenFilter) {
                table.columns(11).search('^' + kompenFilter + '$', true, false); // Exact match for Kompen/Tidak Kompen using regex
            } else {
                table.columns(11).search(''); // Clear filter if no value
            }

            table.draw();
        });

        $('#clear-filter-button').on('click', function() {
            $('#filter-class').val(null).trigger('change');
            $('#filter-prodi').val(null).trigger('change');
            $('#filter-semester').val(null).trigger('change');
            $('#filter-year').val(null).trigger('change');
            $('#filter-kompen').val(null).trigger('change');
            table.search('').columns().search('').draw(); // Clear DataTables filters
        });
    });
</script>
@endsection
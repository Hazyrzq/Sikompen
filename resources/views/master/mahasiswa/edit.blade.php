@extends('super.master-layout')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(16, 185, 129, 0.05);
        transition: background-color 0.3s ease;
    }
    .form-control:focus {
        border-color: rgba(16, 185, 129, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
</style>
@endsection

@section('title', 'Edit Mahasiswa')

@section('content')


<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Mahasiswa</h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="" class="text-gray-600 hover:text-emerald-600 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <a href="{{ route('master.mahasiswa.listmahasiswa') }}" class="text-gray-600 hover:text-emerald-600">
                            List Mahasiswa
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="text-gray-500">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-5">
                <h3 class="text-xl font-semibold text-gray-800">Edit Data Mahasiswa</h3>
            </div>
            
            <form method="POST" action="{{ route('mahasiswa.edit.proses') }}">
                @csrf
                <!-- hidden old id -->
                <input value="{{ $dataMahasiswa->id_mahasiswa }}" type="hidden" name="oldid" id="oldid">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nama_user" class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                        <input type="text" value="{{ $dataMahasiswa->nama_user }}" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            id="nama_user" name="nama_user" required>
                    </div>
                    
                    <div>
                        <label for="kode_user" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                        <input type="text" value="{{ $dataMahasiswa->kode_user }}" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            id="kode_user" name="kode_user" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $dataMahasiswa->email }}" 
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                        id="email" name="email" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <select name="prodi" id="prodi" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            required>
                            @foreach($prodiList as $prodi)
                                <option value="{{ $prodi->prodi }}" 
                                    {{ $dataMahasiswa->prodi == $prodi->prodi ? 'selected' : '' }}>
                                    {{ $prodi->prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" id="kelas" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            required>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->kelas }}" 
                                    {{ $dataMahasiswa->kelas == $kelas->kelas ? 'selected' : '' }}>
                                    {{ $kelas->kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select name="semester" id="semester" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            required>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" 
                                    {{ $dataMahasiswa->semester == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="jumlah_terlambat" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Terlambat (menit)</label>
                        <input type="number" value="{{ $dataMahasiswa->jumlah_terlambat }}" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            id="jumlah_terlambat" name="jumlah_terlambat" required>
                    </div>
                    
                    <div>
                        <label for="jumlah_alfa" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Alfa (jam)</label>
                        <input type="number" value="{{ $dataMahasiswa->jumlah_alfa }}" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            id="jumlah_alfa" name="jumlah_alfa" required>
                    </div>
                    
                    <div>
                        <label for="total" class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                        <input type="number" value="{{ $dataMahasiswa->total }}" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            id="total" name="total" required>
                    </div>
                </div>

                <div class="flex mt-8 space-x-3">
                    <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center" 
                            type="button" id="save-button" onclick="showConfirmation()">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('master.mahasiswa.listmahasiswa') }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script>
    function showConfirmation() {
        let allInputs = document.querySelectorAll('input[required], select[required]');
        let isValid = true;
        let validationErrors = [];

        allInputs.forEach(function(input) {
            if (input.value.trim() === '') {
                isValid = false;
                validationErrors.push('Ada input yang kosong!');
            }
        });
        
        // Email validation
        let emailInput = document.getElementById('email');
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value !== '' && !emailPattern.test(emailInput.value)) {
            isValid = false;
            validationErrors.push('Format email tidak valid!');
        }

        if (isValid) {
            Swal.fire({
                title: 'Apakah anda yakin akan menyimpan perubahan data ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('form').submit();
                }
            });
        } else {
            Swal.fire({
                title: 'Validasi Gagal',
                icon: 'error',
                html: validationErrors.join('<br>'),
            });

            return false;
        }
    }
</script>

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
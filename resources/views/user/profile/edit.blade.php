@extends('super.master-layout')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('title', 'Edit Profile')

@section('content')


<!-- Content -->
<div class="container mx-auto px-4 sm:px-6 mt-6">
    @if (Session::has('message'))
    <div class="mb-4 {{ Session::get('class') == 'alert-success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }} px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ Session::get('message') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Profile</h2>
            <hr class="mb-6">
            
            <form method="POST" action="{{ route('user.profile.edit.proses') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-5">
                    <!-- Kode User -->
                    <div>
                        <label for="kode_user" class="block text-sm font-medium text-gray-700 mb-1">Kode User</label>
                        <input type="text" value="{{ $dataUserMaster->kode_user }}" 
                               class="select-element w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                               id="kode_user" name="kode_user" required>
                    </div>

                    <!-- Nama User -->
                    <div>
                        <label for="nama_user" class="block text-sm font-medium text-gray-700 mb-1">Nama User</label>
                        <input type="text" value="{{ $dataUserMaster->nama_user }}" 
                               class="select-element w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                               id="nama_user" name="nama_user" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $dataUserMaster->email }}" 
                               class="select-element w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                               id="email" name="email" pattern=".*@.*" required>
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" 
                                   class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                                   id="new_password" name="new_password" 
                                   placeholder="Hanya isi jika ingin mengganti password">
                            <button type="button" id="showNewPasswordBtn" 
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600 hover:text-emerald-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" 
                                   class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                                   id="confirm_password" name="confirm_password" 
                                   placeholder="Hanya isi jika ingin mengganti password">
                            <button type="button" id="showConfirmPasswordBtn" 
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600 hover:text-emerald-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tanda Tangan (Jika Role Sesuai) -->
                    @if (in_array($dataUserMaster->role, ['Pengawas', 'PLP', 'Kepala Lab']))
                    <div class="pt-2">
                        <label for="form_ttd" class="block text-sm font-medium text-gray-700 mb-1">Upload Tanda Tangan (TTD)</label>
                        <div class="mt-1 flex items-center">
                            <label class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg border border-gray-300 
                                          cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span class="mt-2 text-sm text-gray-500">Klik untuk memilih file</span>
                                <input type="file" class="hidden" id="form_ttd" name="form_ttd">
                            </label>
                        </div>
                        <div id="file-selected" class="text-sm text-gray-500 mt-1">Tidak ada file terpilih</div>
                    </div>

                    <div class="pt-2">
                        <label for="current_ttd" class="block text-sm font-medium text-gray-700 mb-1">Tanda Tangan Saat Ini</label>
                        <div class="mt-1">
                            @if (!empty($dataUserMaster->ttd))
                                <div class="mt-2 border border-gray-200 rounded-lg p-2 inline-block">
                                    <img src="{{ asset('storage/signature/' . $dataUserMaster->ttd) }}" 
                                         alt="Tanda Tangan Saat Ini" class="max-w-xs">
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                    <span class="text-gray-500">Tidak ada TTD yang diunggah.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <button type="submit" class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                        <i class="fas fa-save mr-2"></i> Update Profile
                    </button>
                    <a href="{{ $referrer ?? url()->previous() }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // File input display
    document.getElementById('form_ttd')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Tidak ada file terpilih';
        document.getElementById('file-selected').textContent = fileName;
    });
    
    // Password Baru
    document.getElementById('showNewPasswordBtn').addEventListener('click', function() {
        var newPasswordInput = document.getElementById('new_password');
        var icon = this.querySelector('i');
        
        if (newPasswordInput.type === 'password') {
            newPasswordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            newPasswordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Konfirmasi Password
    document.getElementById('showConfirmPasswordBtn').addEventListener('click', function() {
        var confirmPasswordInput = document.getElementById('confirm_password');
        var icon = this.querySelector('i');
        
        if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            confirmPasswordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
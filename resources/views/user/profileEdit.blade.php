@extends('super.master-layout')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('title', 'User Setting')

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
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit User Profile</h2>
            <hr class="mb-6">
            
            <form method="POST" action="{{ route('user.profileEdit.proses') }}">
                @csrf

                <input value="{{ $dataUserMaster->id_user }}" type="hidden" name="oldid" id="oldid">
                <input value="{{ $dataUserMaster->username }}" type="hidden" name="oldusername" id="oldusername">

                <div class="space-y-5">
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
                               id="email" name="email" pattern=".*@.*">
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" value="{{ $dataUserMaster->username }}" 
                               class="select-element w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                               id="username" name="username">
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
                </div>

                <input type="hidden" name="form_submitted" value="0">

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
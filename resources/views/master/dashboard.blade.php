@extends('super.master-layout')

@section('title', 'Dashboard')

@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-card {
        transition: all 0.3s ease;
        transform-origin: center;
        border-radius: 12px;
        overflow: hidden;
        opacity: 0;
        transform: translateY(20px);
        animation: cardAppear 0.5s forwards;
    }
    
    @keyframes cardAppear {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dashboard-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Mengatur margin konten agar sesuai dengan sidebar yang tertutup */
    #mainContent {
        margin-left: 4rem !important;
        transition: margin-left 0.3s ease;
    }
</style>
@endsection

@section('content')
<!-- Include sidebar di sini -->
@include('super.SidebarAdmin')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <!-- Total Pekerjaan Card -->
    <a href="{{ route('master.pekerjaan.listpekerjaan') }}" class="dashboard-card" style="animation-delay: 0.1s">
        <div class="bg-purple-600 text-white rounded-lg p-6 flex items-center justify-between">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-2">{{ $totalPekerjaan ?? '11' }}</h2>
                <p class="text-xl md:text-2xl font-medium">Total Pekerjaan</p>
            </div>
            <div class="bg-purple-500 bg-opacity-30 p-4 rounded-full">
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
    </a>

    <!-- Total Mahasiswa Card -->
    <a href="{{ route('master.mahasiswa.listmahasiswa') }}" class="dashboard-card" style="animation-delay: 0.2s">
        <div class="bg-blue-600 text-white rounded-lg p-6 flex items-center justify-between">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-2">{{ $totalMahasiswa ?? '1' }}</h2>
                <p class="text-xl md:text-2xl font-medium">Total Mahasiswa</p>
            </div>
            <div class="bg-blue-500 bg-opacity-30 p-4 rounded-full">
                <i class="fas fa-users text-3xl"></i>
            </div>
        </div>
    </a>

    <!-- Total Pengelola Card -->
    <a href="{{ route('master.user.listuser') }}" class="dashboard-card" style="animation-delay: 0.3s">
        <div class="bg-teal-600 text-white rounded-lg p-6 flex items-center justify-between">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-2">{{ $totalUser ?? '7' }}</h2>
                <p class="text-xl md:text-2xl font-medium">Total Pengelola</p>
            </div>
            <div class="bg-teal-500 bg-opacity-30 p-4 rounded-full">
                <i class="fas fa-user-circle text-3xl"></i>
            </div>
        </div>
    </a>

   
</div>
@endsection

@section('custom-js')
<script>
    // Tidak perlu script tambahan karena animasi sudah diatur dengan CSS
</script>
@endsection
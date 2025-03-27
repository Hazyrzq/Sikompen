<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Dashboard' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/LogoPNJ.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Efek glass */
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        /* Efek hover card */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Efek klik card */
        .clickable-card {
            position: relative;
            overflow: hidden;
        }

        .clickable-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .clickable-card:hover::after {
            opacity: 1;
        }

        /* Animasi dropdown */
        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-8px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-8px) scale(0.95);
            }
        }

        .dropdown-animate {
            animation: slideDown 0.2s ease forwards;
        }

        .dropdown-animate-up {
            animation: slideUp 0.2s ease forwards;
        }

        /* Transisi dan hover efek tambahan */
        .border-b-2 {
            transition: border-color 0.3s ease, color 0.3s ease;
        }

        .border-emerald-500:hover {
            border-color: rgb(16 185 129 / 0.7);
        }

        a.group {
            transition: all 0.3s ease;
        }

        a.group:hover {
            transform: translateY(-1px);
        }
        
        /* Perbaikan tabel */
        .data-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        
        .data-table th {
            background-color: #f9fafb;
            font-weight: 600;
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .data-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .data-table tr:hover {
            background-color: #f3f4f6;
        }
        
        /* Konten utama */
        #mainContent {
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 4rem);
        }
        
        /* Responsif fixes */
        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed top-0 w-full z-40">
        <div class="w-full px-4 md:px-8 lg:px-20">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('assets/images/LogoPNJ.png') }}" alt="Logo" class="h-10 w-10 md:h-12 md:w-12">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 truncate">{{ $pageTitle ?? 'Menu Dashboard' }}</h1>
                        <p class="text-xs md:text-sm text-gray-600 truncate">
                            Kelola Detail Dashboard Menu Anda, 
                            {{ $nama_user ?? 'Tamu' }}
                        </p>
                    </div>
                </div>

                <!-- Enhanced Dropdown Component -->
                <div class="relative">
                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button" onclick="toggleDropdown(event)"
                                class="flex items-center space-x-2 md:space-x-3 px-2 md:px-4 py-2 rounded-lg hover:bg-gray-100 focus:outline-none transition-all duration-200">

                                <img src="{{ asset('assets/images/icons/Profile.png') }}" alt="Profil"
                                    class="h-8 w-8 md:h-10 md:w-10 rounded-full border-2 border-emerald-500 hover:border-emerald-600 transition-colors duration-200">
                                <div class="flex flex-col items-start hidden md:block">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $nama_user ?? 'Tamu' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $role ?? 'Tidak Ada Peran' }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" id="dropdownArrow"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 transform origin-top-right">
                            <div class="py-1 dropdown-animate">
                                <!-- User Info Section -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $nama_user ?? 'Tamu' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $role ?? 'Tidak Ada Peran' }}
                                    </p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                    <a href="{{ route('user.profile.edit') }}"
                                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 transition-all duration-200">
                                        <i class="fas fa-user-edit w-5 h-5 mr-3 text-gray-400 group-hover:text-emerald-500"></i>
                                        Perbarui Profil
                                    </a>

                                    <button onclick="showLogoutModal()"
                                        class="w-full group flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-red-400 group-hover:text-red-500"></i>
                                        Keluar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Include sidebar navigation from separate file -->
    

    <!-- Main Content Container -->
    <div id="mainContent" class="transition-all duration-300 pt-20 px-4 md:px-6 lg:px-8 ml-16 lg:ml-64">
        
            
            <!-- Main Content -->
            @yield('content')
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300 opacity-0"
            id="logoutBackdrop"></div>

        <div class="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm px-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 transform transition-all duration-300 opacity-0 scale-95"
                id="logoutContent">
                <div class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <i class="fas fa-sign-out-alt text-red-600 text-xl"></i>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Konfirmasi Keluar</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Apakah Anda yakin ingin keluar? Anda perlu masuk kembali untuk mengakses akun Anda.
                    </p>
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    <button onclick="closeLogoutModal()"
                        class="flex-1 rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-200 transition-colors duration-200">
                        Batal
                    </button>
                    <button onclick="confirmLogout()"
                        class="flex-1 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition-colors duration-200">
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Main Scripts -->
    <script>
        // Dropdown functionality
        let isDropdownOpen = false;
        let dropdownTimeout;

        function toggleDropdown(event) {
            if (event) {
                event.stopPropagation();
            }
            const dropdown = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');

            if (!isDropdownOpen) {
                dropdown.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';

                const content = dropdown.querySelector('.dropdown-animate');
                content.style.animation = 'none';
                content.offsetHeight;
                content.style.animation = '';

                document.addEventListener('click', handleClickOutside);
            } else {
                hideDropdown();
            }

            isDropdownOpen = !isDropdownOpen;
        }

        function hideDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');
            const content = dropdown.querySelector('.dropdown-animate');

            if (!dropdown || !content) return;

            content.classList.add('dropdown-animate-up');
            arrow.style.transform = 'rotate(0deg)';

            if (dropdownTimeout) {
                clearTimeout(dropdownTimeout);
            }

            content.addEventListener('animationend', function handler() {
                dropdown.classList.add('hidden');
                content.classList.remove('dropdown-animate-up');
                this.removeEventListener('animationend', handler);
                isDropdownOpen = false;
            }, { once: true });
        }

        function handleClickOutside(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = document.querySelector('button[onclick="toggleDropdown(event)"]');

            if (dropdown && !dropdown.contains(event.target) && !button.contains(event.target)) {
                hideDropdown();
                document.removeEventListener('click', handleClickOutside);
            }
        }

        // Logout Modal Functions
        function showLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const backdrop = document.getElementById('logoutBackdrop');
            const content = document.getElementById('logoutContent');

            modal.classList.remove('hidden');
            void modal.offsetWidth;
            backdrop.classList.add('opacity-100');
            content.classList.remove('opacity-0', 'scale-95');
            content.classList.add('opacity-100', 'scale-100');
        }

        function closeLogoutModal() {
            const backdrop = document.getElementById('logoutBackdrop');
            const content = document.getElementById('logoutContent');

            backdrop.classList.remove('opacity-100');
            content.classList.remove('opacity-100', 'scale-100');
            content.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                document.getElementById('logoutModal').classList.add('hidden');
            }, 300);
        }

        function confirmLogout() {
            window.location.href = '{{ route("logout") }}';
        }

        // Handle Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                if (isDropdownOpen) {
                    hideDropdown();
                }
                closeLogoutModal();
            }
        });

        // Close modal when clicking backdrop
        document.getElementById('logoutBackdrop').addEventListener('click', closeLogoutModal);
    </script>

    @stack('scripts')
</body>
</html>
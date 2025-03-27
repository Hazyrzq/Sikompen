<!-- Sidebar -->
<div id="sidebar" class="fixed left-0 top-16 bottom-0 w-64 bg-white shadow-lg z-30 transform transition-transform duration-300">
    <div class="overflow-y-auto h-full">
        <div class="p-4">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('master.dashboard') }}" 
                       class="group py-3 px-4 rounded-lg flex items-center space-x-3 {{ request()->routeIs('master.dashboard') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                        <i class="fas fa-tachometer-alt w-5 h-5 text-{{ request()->routeIs('master.dashboard') ? 'emerald-500' : 'gray-500 group-hover:text-emerald-500' }} transition-colors duration-200"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="mb-2">
                    <a href="{{ route('master.pekerjaan.listpekerjaan') }}" 
                       class="group py-3 px-4 rounded-lg flex items-center space-x-3 {{ request()->routeIs('master.pekerjaan.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                        <i class="fas fa-briefcase w-5 h-5 text-{{ request()->routeIs('master.pekerjaan.*') ? 'emerald-500' : 'gray-500 group-hover:text-emerald-500' }} transition-colors duration-200"></i>
                        <span>Pekerjaan</span>
                    </a>
                </li>
                
                <li class="mb-2">
                    <a href="{{ route('master.mahasiswa.listmahasiswa') }}" 
                       class="group py-3 px-4 rounded-lg flex items-center space-x-3 {{ request()->routeIs('master.mahasiswa.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                        <i class="fas fa-users w-5 h-5 text-{{ request()->routeIs('master.mahasiswa.*') ? 'emerald-500' : 'gray-500 group-hover:text-emerald-500' }} transition-colors duration-200"></i>
                        <span>Mahasiswa</span>
                    </a>
                </li>
                
                <li class="mb-2">
                    <a href="{{ route('master.user.listuser') }}" 
                       class="group py-3 px-4 rounded-lg flex items-center space-x-3 {{ request()->routeIs('master.user.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                        <i class="fas fa-user-circle w-5 h-5 text-{{ request()->routeIs('master.user.*') ? 'emerald-500' : 'gray-500 group-hover:text-emerald-500' }} transition-colors duration-200"></i>
                        <span>Pengelola</span>
                    </a>
                </li>
                
                <li class="mb-2">
                    <a href="{{ route('master.setup.listsetup') }}" 
                       class="group py-3 px-4 rounded-lg flex items-center space-x-3 {{ request()->routeIs('master.setup.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                        <i class="fas fa-cog w-5 h-5 text-{{ request()->routeIs('master.setup.*') ? 'emerald-500' : 'gray-500 group-hover:text-emerald-500' }} transition-colors duration-200"></i>
                        <span>Setup</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Overlay for sidebar -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-0 pointer-events-none transition-opacity duration-300 z-20"></div>

<script>
    // Sidebar Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (sidebarToggle && sidebar && mainContent) {
            // Set initial state based on screen size
            let isSidebarOpen = window.innerWidth >= 768;
            updateSidebarState();

            // Toggle sidebar when button is clicked
            sidebarToggle.addEventListener('click', function() {
                isSidebarOpen = !isSidebarOpen;
                updateSidebarState();
            });
            
            // Close sidebar when clicking on overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    isSidebarOpen = false;
                    updateSidebarState();
                });
            }

            // Update sidebar state on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth < 768 && isSidebarOpen) {
                    sidebarOverlay.classList.add('opacity-50');
                    sidebarOverlay.classList.remove('pointer-events-none');
                } else if (window.innerWidth >= 768) {
                    sidebarOverlay.classList.remove('opacity-50');
                    sidebarOverlay.classList.add('pointer-events-none');
                }
            });

            // Function to update sidebar state
            function updateSidebarState() {
                if (isSidebarOpen) {
                    // Open sidebar
                    sidebar.style.transform = 'translateX(0)';
                    mainContent.classList.remove('ml-0');
                    mainContent.classList.add('ml-64');
                    
                    // On mobile, show overlay
                    if (window.innerWidth < 768) {
                        sidebarOverlay.classList.remove('pointer-events-none');
                        sidebarOverlay.classList.add('opacity-50');
                    }
                } else {
                    // Close sidebar
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.classList.remove('ml-64');
                    mainContent.classList.add('ml-0');
                    
                    // Hide overlay
                    sidebarOverlay.classList.add('pointer-events-none');
                    sidebarOverlay.classList.remove('opacity-50');
                }
            }
        }
    });

    // Handle Escape key to close sidebar
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (sidebar && getComputedStyle(sidebar).transform !== 'matrix(1, 0, 0, 1, -256, 0)') {
                sidebar.style.transform = 'translateX(-100%)';
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-0');
                sidebarOverlay.classList.add('pointer-events-none');
                sidebarOverlay.classList.remove('opacity-50');
            }
        }
    });
</script>
<!-- Responsive Sidebar Navigation -->
<div class="sidebar-container fixed left-0 top-0 bottom-0 h-screen z-30 transition-all duration-300 ease-in-out"
    id="sidebarContainer">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-white shadow-lg h-full overflow-y-auto transition-all duration-300 ease-in-out">
        <!-- Sidebar content -->
        <div class="sidebar-content h-full flex flex-col">
            <!-- Top header area with possible logo -->
            <div class="h-16 flex items-center justify-center border-b border-gray-100">
                <div class="flex items-center px-4">
                    <!-- Logo placeholder -->
                </div>
            </div>

            <!-- Navigation menu -->
            <nav class="flex flex-col flex-grow pt-9">
                <div class="px-4 pb-5">
                    <a href="{{ route('master.dashboard') }}"
                        class="{{ request()->routeIs('master.dashboard') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }} flex items-center h-10 px-4 rounded-lg transition-all duration-200 group mb-2">
                        <div class="w-5 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <span class="menu-text ml-3 whitespace-nowrap sidebar-expanded-only font-medium">Dasboard</span>
                    </a>

                    <a href="{{ route('master.pekerjaan.listpekerjaan') }}"
                        class="{{ request()->routeIs('master.pekerjaan.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }} flex items-center h-10 px-4 rounded-lg transition-all duration-200 group mb-2">
                        <div class="w-5 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span
                            class="menu-text ml-3 whitespace-nowrap sidebar-expanded-only font-medium">Pekerjaan</span>
                    </a>

                    <a href="{{ route('master.user.listuser') }}"
                        class="{{ request()->routeIs('master.user.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }} flex items-center h-10 px-4 rounded-lg transition-all duration-200 group mb-2">
                        <div class="w-5 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span
                            class="menu-text ml-3 whitespace-nowrap sidebar-expanded-only font-medium">Pengelola</span>
                    </a>
                    <a href="{{ route('master.mahasiswa.listmahasiswa') }}"
                        class="{{ request()->routeIs('master.mahasiswa.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }} flex items-center h-10 px-4 rounded-lg transition-all duration-200 group mb-2">
                        <div class="w-5 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5m0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                        <span
                            class="menu-text ml-3 whitespace-nowrap sidebar-expanded-only font-medium">Mahasiswa</span>
                    </a>
                    <a href="{{ route('master.kelas.listkelas') }}"
                        class="{{ request()->routeIs('master.kelas.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }} flex items-center h-10 px-4 rounded-lg transition-all duration-200 group mb-2">
                        <div class="w-5 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13h8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17h8" />
                            </svg>
                        </div>
                        <span class="menu-text ml-3 whitespace-nowrap sidebar-expanded-only font-medium">List
                            Kelas</span>
                    </a>
                    <a href="{{ route('master.prodi.listprodi') }}"
                        class="{{ request()->routeIs('master.prodi.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }} flex items-center h-10 px-4 rounded-lg transition-all duration-200 group mb-2">
                        <div class="w-5 flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="menu-text ml-3 whitespace-nowrap sidebar-expanded-only font-medium">List
                            Prodi</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Toggle button centered on the edge -->
    <button id="sidebarToggle"
        class="absolute rounded-full p-1.5 shadow-lg z-40 bg-emerald-500 text-white transition-all duration-300 ease-in-out hover:bg-emerald-600 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="toggleIcon" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
</div>

<!-- Required styles -->
<style>
    /* Responsive sidebar styles with precise measurements */
    .sidebar-container {
        width: 240px;
        /* Width when open */
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-container.collapsed {
        width: 70px;
        /* Width when closed */
    }

    /* Toggle button positioning - precisely centered */
    #sidebarToggle {
        right: -12px;
        top: 50%;
        transform: translateY(-50%);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        height: 32px;
        width: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Hide/show elements based on sidebar status */
    .sidebar-collapsed-only {
        display: none;
    }

    .sidebar-container.collapsed .sidebar-expanded-only {
        display: none;
    }

    .sidebar-container.collapsed .sidebar-collapsed-only {
        display: flex;
    }

    /* Better menu item alignment */
    .sidebar-container.collapsed a {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    .sidebar-container.collapsed .w-5 {
        margin: 0;
        width: 20px;
    }

    /* Menu text animation with precise timing */
    .menu-text {
        opacity: 1;
        max-width: 160px;
        visibility: visible;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-container.collapsed .menu-text {
        opacity: 0;
        max-width: 0;
        margin-left: 0;
        visibility: hidden;
    }

    /* Main content adjustment with fixed values */
    #mainContent {
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-left: 240px;
    }

    .sidebar-container.collapsed~#mainContent {
        margin-left: 70px;
    }
</style>

<!-- Script for sidebar functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarContainer = document.getElementById('sidebarContainer');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');

        // Set initial state based on saved preference
        const savedState = localStorage.getItem('sidebarState');

        if (savedState === 'collapsed') {
            sidebarContainer.classList.add('collapsed');
            toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />';
        } else {
            toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />';
        }

        // Update main content margin if it exists
        if (mainContent) {
            updateMainContentMargin();
        }

        // Function to update main content margin
        function updateMainContentMargin() {
            if (sidebarContainer.classList.contains('collapsed')) {
                mainContent.style.marginLeft = '70px';
            } else {
                mainContent.style.marginLeft = '240px';
            }
        }

        // Function to toggle sidebar
        function toggleSidebar() {
            sidebarContainer.classList.toggle('collapsed');

            // Adjust main content margin
            if (mainContent) {
                updateMainContentMargin();
            }

            // Change toggle icon direction
            if (sidebarContainer.classList.contains('collapsed')) {
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />';
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />';
                localStorage.setItem('sidebarState', 'expanded');
            }
        }

        // Toggle button click handler
        sidebarToggle.addEventListener('click', toggleSidebar);

        // Hover functionality for desktop only
        const mediaQuery = window.matchMedia('(min-width: 1024px)');
        let hoverTimer;

        function handleMouseEnter() {
            clearTimeout(hoverTimer);
            if (sidebarContainer.classList.contains('collapsed') && localStorage.getItem('sidebarState') !== 'expanded') {
                sidebarContainer.classList.remove('collapsed');
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />';
                if (mainContent) updateMainContentMargin();
            }
        }

        function handleMouseLeave() {
            if (!sidebarContainer.classList.contains('collapsed') && localStorage.getItem('sidebarState') !== 'expanded') {
                hoverTimer = setTimeout(function () {
                    sidebarContainer.classList.add('collapsed');
                    toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />';
                    if (mainContent) updateMainContentMargin();
                }, 300);
            }
        }

        function setupHoverBehavior(matches) {
            if (matches) {
                sidebarContainer.addEventListener('mouseenter', handleMouseEnter);
                sidebarContainer.addEventListener('mouseleave', handleMouseLeave);
            } else {
                sidebarContainer.removeEventListener('mouseenter', handleMouseEnter);
                sidebarContainer.removeEventListener('mouseleave', handleMouseLeave);
            }
        }

        // Setup initial hover behavior
        setupHoverBehavior(mediaQuery.matches);

        // Update hover behavior when screen size changes
        mediaQuery.addEventListener('change', function (e) {
            setupHoverBehavior(e.matches);
        });
    });
</script>
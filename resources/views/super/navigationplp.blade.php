<div class="w-full px-6 mx-auto mt-6">
    <div class="border-b border-gray-200 bg-white rounded-t-lg">
        <nav class="flex">
            <a href="{{ route('plp.listpengajuan') }}"
                class="relative {{ request()->routeIs('plp.listpengajuan') ? 'border-b-2 border-emerald-500 text-emerald-600' : 'border-b-2 border-transparent text-gray-500 hover:text-emerald-600 hover:border-emerald-300' }} px-6 py-3 text-sm font-medium group transition-all duration-300">
                <span class="relative z-10">Daftar Pengajuan</span>
                <div
                    class="absolute inset-0 bg-emerald-50 scale-0 group-hover:scale-100 transition-transform duration-300 origin-center rounded-lg">
                </div>
            </a>
            <a href="{{ route('plp.listdisetujui') }}"
                class="relative {{ request()->routeIs('plp.listdisetujui') ? 'border-b-2 border-emerald-500 text-emerald-600' : 'border-b-2 border-transparent text-gray-500 hover:text-emerald-600 hover:border-emerald-300' }} px-6 py-3 text-sm font-medium group transition-all duration-300">
                <span class="relative z-10">Daftar Disetujui</span>
                <div
                    class="absolute inset-0 bg-emerald-50 scale-0 group-hover:scale-100 transition-transform duration-300 origin-center rounded-lg">
                </div>
            </a>
        </nav>
    </div>
</div>
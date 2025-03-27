@extends('super.master-layout')

@section('custom-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: rgba(16, 185, 129, 0.7);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .tooltip {
            position: absolute;
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            display: none;
        }

        .info-icon {
            cursor: pointer;
            color: #10b981;
            margin-left: 5px;
        }

        .info-icon:hover+.tooltip {
            display: block;
        }
    </style>
@endsection

@section('title', 'Tambah Mahasiswa')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 mt-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Mahasiswa</h2>

                <form action="{{ route('mahasiswa.add.proses') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="kode_user" class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                            <input type="text" name="kode_user" id="kode_user" required
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                        </div>

                        <div>
                            <label for="nama_user" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                Mahasiswa</label>
                            <input type="text" name="nama_user" id="nama_user" required
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" required
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                        </div>

                        <div>
                            <label for="notelp" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon
                                (Opsional)</label>
                            <input type="text" name="notelp" id="notelp"
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="prodi" class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                            <select name="prodi" id="prodi" required
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                                <option value="">Pilih Program Studi</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->prodi }}">{{ $p->prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="kelas" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                            <select name="kelas" id="kelas" required
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->kelas }}">{{ $k->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                            <select name="semester" id="semester" required
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                                <option value="">Pilih Semester</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="total" class="block text-sm font-medium text-gray-700 mb-2">
                                Total Poin
                                <i class="fas fa-info-circle text-emerald-500"
                                    title="Perhitungan: Terlambat (menit x 2) + Alfa (jam x 60 x 2)"></i>
                            </label>
                            <input type="number" name="total" id="total" value="0" readonly
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none bg-gray-100 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jumlah_terlambat" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Terlambat (menit)
                                <i class="fas fa-info-circle text-emerald-500"
                                    title="Setiap menit terlambat dikalikan 2"></i>
                            </label>
                            <div class="relative">
                                <input type="number" name="jumlah_terlambat" id="jumlah_terlambat" value="0" min="0"
                                    step="1"
                                    class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                                <small class="text-gray-500 block mt-1">Poin Terlambat: <span
                                        id="poin_terlambat">0</span></small>
                            </div>
                        </div>

                        <div>
                            <label for="jumlah_alfa" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Alfa (jam)
                                <i class="fas fa-info-circle text-emerald-500" title="Setiap jam alfa dikalikan 60 x 2"></i>
                            </label>
                            <div class="relative">
                                <input type="number" name="jumlah_alfa" id="jumlah_alfa" value="0" min="0" step="0.5"
                                    class="form-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                                <small class="text-gray-500 block mt-1">Poin Alfa: <span id="poin_alfa">0</span></small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('master.mahasiswa.listmahasiswa') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-content')
    <script>
        // Fungsi untuk menghitung total poin - versi robust
        function calculateTotal() {
            console.log("calculateTotal function called");
            
            // Ambil nilai terlambat (menit) dengan validasi tambahan
            const terlambatInput = document.getElementById('jumlah_terlambat');
            let terlambatMenit = 0;
            if (terlambatInput && terlambatInput.value) {
                terlambatMenit = parseFloat(terlambatInput.value) || 0;
            }
            console.log("Terlambat menit:", terlambatMenit);

            // Ambil nilai alfa (jam) dengan validasi tambahan
            const alfaInput = document.getElementById('jumlah_alfa');
            let alfaJam = 0;
            if (alfaInput && alfaInput.value) {
                alfaJam = parseFloat(alfaInput.value) || 0;
            }
            console.log("Alfa jam:", alfaJam);

            // Hitung poin terlambat (menit * 2)
            let terlambatPoin = terlambatMenit * 2;
            console.log("Poin terlambat:", terlambatPoin);
            
            // Hitung poin alfa (jam ke menit * 2)
            let alfaPoin = alfaJam * 60 * 2;
            console.log("Poin alfa:", alfaPoin);
            
            // Hitung total poin
            let totalPoin = terlambatPoin + alfaPoin;
            console.log("Total poin:", totalPoin);
            
            // Set nilai total field
            const totalField = document.getElementById('total');
            if (totalField) {
                totalField.value = Math.round(totalPoin);
                console.log("Total field updated:", totalField.value);
            }
            
            // Update tampilan poin terlambat
            const poinTerlambatElement = document.getElementById('poin_terlambat');
            if (poinTerlambatElement) {
                poinTerlambatElement.textContent = Math.round(terlambatPoin);
                console.log("Poin terlambat display updated:", poinTerlambatElement.textContent);
            }
            
            // Update tampilan poin alfa
            const poinAlfaElement = document.getElementById('poin_alfa');
            if (poinAlfaElement) {
                poinAlfaElement.textContent = Math.round(alfaPoin);
                console.log("Poin alfa display updated:", poinAlfaElement.textContent);
            }
        }

        // Fungsi untuk memastikan event listener terpasang dengan benar
        function setupEventListeners() {
            console.log("Setting up event listeners");
            
            const terlambatInput = document.getElementById('jumlah_terlambat');
            const alfaInput = document.getElementById('jumlah_alfa');
            
            if (terlambatInput) {
                console.log("Adding event listener to terlambat input");
                terlambatInput.addEventListener('input', calculateTotal);
                terlambatInput.addEventListener('change', calculateTotal);
            }
            
            if (alfaInput) {
                console.log("Adding event listener to alfa input");
                alfaInput.addEventListener('input', calculateTotal);
                alfaInput.addEventListener('change', calculateTotal);
            }
            
            // Run calculation immediately
            calculateTotal();
        }

        // Pastikan DOM selesai dimuat
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupEventListeners);
        } else {
            setupEventListeners();
        }

        // Tambahan - coba jalankan setelah beberapa detik untuk menangani load script yang terlambat
        setTimeout(calculateTotal, 500);
    </script>
@endsection
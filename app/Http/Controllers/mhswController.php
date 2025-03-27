<?php

namespace App\Http\Controllers;

use App\Models\MMahasiswa;
use App\Models\MProdi;
use App\Models\MKelas;
use App\Models\MPengajuan;
use Illuminate\Support\Facades\Log;
use App\Mail\resetPasswordMail;
use App\Models\MSetupBertugas;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\MPengajuanDetail;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

class mhswController extends Controller
{
    public function mahasiswaShow(Request $request)
    {
        $dataMahasiswa = MMahasiswa::all(); //narik semua dari db kirim ke view
        return view('master.mahasiswa.listmahasiswa', ['dataMahasiswa' => $dataMahasiswa]);
    }// Method to show the create form
    public function mahasiswaShowCreate(Request $request)
    {
        // Ambil data prodi dan kelas untuk dropdown
        $prodi = MProdi::all();
        $kelas = MKelas::all();
    
        return view('master.mahasiswa.create', compact('prodi', 'kelas'));
    }
    
    public function mahasiswaProsesAdd(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kode_user' => 'required|unique:tbl_mahasiswa',
            'nama_user' => 'required',
            'email' => 'required|email|unique:tbl_mahasiswa',
            'prodi' => 'required|exists:tbl_prodi,prodi',
            'kelas' => 'required|exists:tbl_kelas,kelas',
            'semester' => 'required|integer|min:1|max:8',
            'jumlah_terlambat' => 'required|numeric|min:0',
            'jumlah_alfa' => 'required|numeric|min:0',
            'notelp' => 'nullable|string'
        ]);
    
        try {
            // Hitung poin terlambat (menit x 2)
            $jumlah_terlambat = $request->input('jumlah_terlambat');
            $poin_terlambat = $jumlah_terlambat * 2;
    
            // Hitung poin alfa (jam x 60 x 2)
            $jumlah_alfa = $request->input('jumlah_alfa');
            $poin_alfa = $jumlah_alfa * 60 * 2;
    
            // Hitung total poin
            $total_poin = $poin_terlambat + $poin_alfa;
    
            // Buat record mahasiswa baru
            $mahasiswa = new MMahasiswa();
            $mahasiswa->kode_user = $request->input('kode_user');
            $mahasiswa->nama_user = $request->input('nama_user');
            $mahasiswa->email = $request->input('email');
            $mahasiswa->prodi = $request->input('prodi');
            $mahasiswa->kelas = $request->input('kelas');
            $mahasiswa->semester = $request->input('semester');
            $mahasiswa->notelp = $request->input('notelp');
            $mahasiswa->jumlah_terlambat = $jumlah_terlambat;
            $mahasiswa->jumlah_alfa = $jumlah_alfa;
            $mahasiswa->total = $total_poin;
            $mahasiswa->role = 'Mahasiswa';
            
            // Simpan data
            $mahasiswa->save();
    
            // Log perhitungan
            \Log::info('Perhitungan Poin Mahasiswa', [
                'jumlah_terlambat' => $jumlah_terlambat,
                'poin_terlambat' => $poin_terlambat,
                'jumlah_alfa' => $jumlah_alfa,
                'poin_alfa' => $poin_alfa,
                'total_poin' => $total_poin
            ]);
    
            // Tambahkan pesan flash dengan detail perhitungan
            Session::flash('alert-success', "Berhasil Menambahkan Data. 
                Poin Terlambat: $jumlah_terlambat menit x 2 = $poin_terlambat. 
                Poin Alfa: $jumlah_alfa jam x 60 x 2 = $poin_alfa. 
                Total Poin: $total_poin");
    
            return redirect()->route('master.mahasiswa.listmahasiswa');
        } catch (Exception $e) {
            // Log error dan flash error message
            \Log::error('Gagal menambahkan mahasiswa: ' . $e->getMessage());
            Session::flash('alert-error', 'Gagal Menambahkan Data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function mahasiswaShowEdit(Request $request)
    {
        // -- ambil dari request id
        $form_id_mahasiswa = $request->query('id_mahasiswa', '');

        $dataMahasiswa = MMahasiswa::findOrFail($form_id_mahasiswa);
        $prodiList = MProdi::all();
        $kelasList = MKelas::all();

        return view('master.mahasiswa.edit', [
            'dataMahasiswa' => $dataMahasiswa,
            'prodiList' => $prodiList,
            'kelasList' => $kelasList
        ]);
    }


    public function mahasiswaProsesEdit(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'oldid' => 'required|exists:tbl_mahasiswa,id_mahasiswa',
        'nama_user' => 'required|string|max:255',
        'kode_user' => 'required|numeric',
        'email' => 'required|email',
        'semester' => 'required|integer|min:1|max:8',
        'jumlah_terlambat' => 'required|numeric|min:0',
        'jumlah_alfa' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0'
    ]);

    // Cari mahasiswa berdasarkan ID
    $tblMahasiswa = MMahasiswa::findOrFail($request->post('oldid'));

    // Cek apakah kode user baru sudah ada di database (jika berbeda)
    if ($request->post('kode_user') != $tblMahasiswa->kode_user) {
        $kode_userExists = MMahasiswa::where('kode_user', $request->post('kode_user'))->exists();
        if ($kode_userExists) {
            Session::flash('alert-error', 'OOPSSS! NIM sudah ada!');
            return redirect()->back()->withInput();
        }
    }

    // Cek apakah email baru sudah ada di database (jika berbeda)
    if ($request->post('email') != $tblMahasiswa->email) {
        $emailExists = MMahasiswa::where('email', $request->post('email'))->exists();
        if ($emailExists) {
            Session::flash('alert-error', 'OOPSSS! Email sudah digunakan!');
            return redirect()->back()->withInput();
        }
    }

    try {
        // Update data mahasiswa
        $tblMahasiswa->kode_user = $request->post('kode_user');
        $tblMahasiswa->nama_user = $request->post('nama_user');
        $tblMahasiswa->email = $request->post('email');
        $tblMahasiswa->semester = $request->post('semester');
        $tblMahasiswa->jumlah_terlambat = $request->post('jumlah_terlambat');
        $tblMahasiswa->jumlah_alfa = $request->post('jumlah_alfa');
        $tblMahasiswa->total = $request->post('total');
        
        // Tetap gunakan kelas dan prodi yang sudah ada
        $tblMahasiswa->kelas = $request->post('kelas');
        $tblMahasiswa->prodi = $request->post('prodi');

        // Simpan perubahan
        $tblMahasiswa->save();

        // Jika total == 0, buat pengajuan baru jika diperlukan
        if ($tblMahasiswa->total == 0) {
            $row = [
                $tblMahasiswa->kode_user,
                $tblMahasiswa->nama_user,
                $tblMahasiswa->kelas,
                $tblMahasiswa->prodi,
                $tblMahasiswa->semester,
                $tblMahasiswa->jumlah_terlambat,
                $tblMahasiswa->jumlah_alfa,
                $tblMahasiswa->total
            ];
            $this->createPengajuan($row, $tblMahasiswa->jumlah_terlambat, $tblMahasiswa->jumlah_alfa, $tblMahasiswa->total);
        }

        // Tampilkan pesan sukses
        Session::flash('alert-success', 'Berhasil Mengubah Data');
        return redirect()->route('master.mahasiswa.listmahasiswa');

    } catch (\Exception $e) {
        // Tangani kesalahan
        \Log::error('Gagal mengupdate mahasiswa: ' . $e->getMessage());
        Session::flash('alert-error', 'Gagal Mengubah Data: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}

// Metode createPengajuan tetap sama seperti yang ada di controller Anda
private function createPengajuan($row, $jumlah_terlambat, $jumlah_alfa, $total)
{
    $setupDataTerakhir = MSetupBertugas::orderBy('tgl_bertugas', 'desc')->take(3)->get();

    // Cek apakah setupDataTerakhir mencakup peran yang sesuai
    $approval1_by = $setupDataTerakhir->where('role', 'Pengawas')->first()->nama_user ?? null;
    $approval2_by = $setupDataTerakhir->where('role', 'Kepala Lab')->first()->nama_user ?? null;
    $approval3_by = $setupDataTerakhir->where('role', 'PLP')->first()->nama_user ?? null;

    // Buat pengajuan baru jika semua role ditemukan
    if ($approval1_by && $approval2_by && $approval3_by) {
        $existingPengajuan = MPengajuan::where('kode_user', $row[0])
            ->where('kelas', $row[2])
            ->where('semester', $row[4])
            ->first();

        if (!$existingPengajuan) {
            $tbl_pengajuan = new MPengajuan();
            $tbl_pengajuan->kode_user = $row[0];
            $tbl_pengajuan->nama_user = $row[1];
            $tbl_pengajuan->kelas = $row[2];
            $tbl_pengajuan->prodi = $row[3];
            $tbl_pengajuan->semester = $row[4];
            $tbl_pengajuan->jumlah_terlambat = $jumlah_terlambat;
            $tbl_pengajuan->jumlah_alfa = $jumlah_alfa;
            $tbl_pengajuan->total = $total;

            $tbl_pengajuan->sisa = '0';
            $tbl_pengajuan->status_approval1 = 'Disetujui';
            $tbl_pengajuan->status_approval2 = 'Disetujui';
            $tbl_pengajuan->status_approval3 = 'Disetujui';
            $tbl_pengajuan->approval1_by = $approval1_by;
            $tbl_pengajuan->approval2_by = $approval2_by;
            $tbl_pengajuan->approval3_by = $approval3_by;

            $tbl_pengajuan->save();
        }
    }
}

    public function mahasiswaProsesDelete(Request $request)
    {
        // Ambil ID user dari permintaan
        $id_mahasiswa = $request->input('id_mahasiswa');

        // Temukan pengguna berdasarkan ID
        $tblMahasiswa = MMahasiswa::findOrFail($id_mahasiswa);

        // Hapus pengguna dari database
        $tblMahasiswa->delete();

        // Beri pesan sukses
        Session::flash('alert-success', 'Berhasil Hapus Data');

        // Redirect ke halaman daftar pengguna
        return redirect()->route('master.mahasiswa.listmahasiswa');
    }

    // public function registrasishow(Request $request)
    // {
    //     $kodeProdiList = MProdi::pluck('nama_prodi', 'id_prodi');
    //     $kodeKelasList = MKelas::pluck('kelas', 'id_kelas');
    //     return view('register', compact('kodeProdiList', 'kodeKelasList'));
    // }
    // public function registrasiProsesAdd(Request $request)
    // {

    //     $kode_user = $request->input('kode_user');
    //     $email = $request->input('email');
    //     $nama_user = $request->input('nama_user');
    //     $notelp = $request->input('notelp');

    //     // Check if any of the unique fields already exist in the database
    //     $existingUser = MMahasiswa::where('kode_user', $kode_user)
    //         ->orWhere('email', $email)
    //         ->orWhere('nama_user', $nama_user)
    //         ->orWhere('notelp', $notelp)
    //         ->first();

    //     if ($existingUser) {
    //         if ($existingUser->kode_user == $kode_user) {
    //             Session::flash('alert-error', 'OOPSSS! NIM sudah ada!');
    //         } elseif ($existingUser->email == $email) {
    //             Session::flash('alert-error', 'OOPSSS! Email sudah ada!');
    //         } elseif ($existingUser->nama_user == $nama_user) {
    //             Session::flash('alert-error', 'OOPSSS! Nama User sudah ada!');
    //         } elseif ($existingUser->notelp == $notelp) {
    //             Session::flash('alert-error', 'OOPSSS! Nomer Telefon sudah ada!');
    //         }
    //         return redirect('/register')->withInput();
    //     }

    //     // Lanjutkan dengan proses penyimpanan data user jika username belum ada di database

    //     $form_kode_user = $request->post('kode_user');
    //     $form_nama_user = $request->post('nama_user');
    //     $form_email = $request->post('email');
    //     $form_prodi = $request->post('prodi');
    //     $form_kelas = $request->post('kelas');
    //     $form_notelp = $request->post('notelp');
    //     $form_password = $request->post('password');
    //     $form_role = $request->post('role');
    //     $hashedPassword = bcrypt($form_password); // Hash password sebelum menyimpannya

    //     //set ke table
    //     $tblMahasiswa = new MMahasiswa();
    //     $tblMahasiswa->kode_user = $form_kode_user;
    //     $tblMahasiswa->nama_user = $form_nama_user;
    //     $tblMahasiswa->email = $form_email;
    //     $tblMahasiswa->prodi = $form_prodi;
    //     $tblMahasiswa->kelas = $form_kelas;
    //     $tblMahasiswa->notelp = $form_notelp;
    //     $tblMahasiswa->password = $hashedPassword;
    //     $tblMahasiswa->role = $form_role;

    //     $tblMahasiswa->save(); // Simpan data ke database

    //     // $id_user = $tblMahasiswa->id_user; //mengambil id data yang baru diinput untuk log
    //     // //membuat log otomatis
    //     // MLogActivity::create([
    //     //     'nama_user' => auth()->guard("karyawan")->user()->nama_user, // Gantilah dengan cara Anda mengambil nama pengguna
    //     //     'aksi' => 'TAMBAH',
    //     //     'keterangan' => 'Menambah data Master User dengan ID = ' . $id_user
    //     // ]);

    //     Session::flash('alert-success', 'Berhasil Menambahkan Data');

    //     // Redirect ke halaman selanjutnya
    //     return redirect('/loginmhsw');
    // }
    public function mahasiswaDataShow(Request $request)
    {
        // Mendapatkan pengguna yang sedang login menggunakan guard 'karyawan'
        $user = Auth::guard('pmahasiswa')->user();

        // Memastikan pengguna sudah login
        if ($user) {
            // Mendapatkan kode_user dari pengguna yang sedang login
            $kodeUser = $user->kode_user;

            // Mengambil data mahasiswa yang terkait dengan kode_user pengguna yang sedang login
            $dataMahasiswa = MMahasiswa::where('kode_user', $kodeUser)->get();

            // Mengirim data ke view
            return view('mahasiswa.listdata', ['dataMahasiswa' => $dataMahasiswa]);
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau menampilkan pesan kesalahan
            return redirect()->route('loginmhsw')->with('error', 'Anda harus login terlebih dahulu');
        }
    }

    public function showmhswloginform()
    {
        return view('loginmhsw'); //
    }

    public function loginmhsw(Request $request)
    {
        // Validasi data login
        $this->validate($request, [
            'kode_user' => 'required',
            'password' => 'required',
        ]);
        // Coba melakukan autentikasi
        if (Auth::guard('pmahasiswa')->attempt(['kode_user' => $request->kode_user, 'password' => $request->password])) {
            // Autentikasi berhasil
            $user = Auth::guard('pmahasiswa')->user();

            $data = ['kode_user' => $user->kode_user];

            if ($user->role === 'Mahasiswa') {
                $request->session()->regenerate();
                // if ($user->edit_password == 0) {
                //     return redirect()->route('user.edit'); // Redirect ke halaman pengaturan pengguna
                // } else {}
                return redirect()->intended('mahasiswa/listdata'); // Redirect ke halaman daftar barang gudang

            } else {
                return redirect('/loginmhsw')->with($data);
            }
        } else {
            // Autentikasi gagal
            Session::flash('alert-error', 'Username Atau Password Salah!');
            return redirect('/loginmhsw');
        }
    }

    // Metode untuk logout
    public function logoutmhsw(Request $request)
    {
        Auth::guard('pmahasiswa')->logout();
        $request->session()->regenerate();
        return redirect()->intended(route('loginmhsw'));
    }

    public function importMahasiswa(Request $request)
    {
        try {
            if ($request->hasFile('excel_file')) {
                $file = $request->file('excel_file');

                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($file);

                $worksheet = $spreadsheet->getActiveSheet();
                $data = $worksheet->toArray();

                $importedCount = 0;
                $updatedCount = 0;

                foreach (array_slice($data, 1) as $row) {
                    $jumlah_terlambat = str_replace([',', '.'], '', $row[5]);
                    $jumlah_alfa = str_replace([',', '.'], '', $row[6]);
                    $total = str_replace([',', '.'], '', $row[7]);

                    $mahasiswa = MMahasiswa::where('kode_user', $row[0])->first();

                    if ($mahasiswa) {
                        $originalKelas = $mahasiswa->kelas;
                        $originalSemester = $mahasiswa->semester;

                        $mahasiswa->kelas = $row[2];
                        $mahasiswa->semester = $row[4];
                        $mahasiswa->jumlah_terlambat = $jumlah_terlambat;
                        $mahasiswa->jumlah_alfa = $jumlah_alfa;
                        $mahasiswa->total = $total;
                        $mahasiswa->save();
                        $updatedCount++;

                        if ($total == 0 && ($originalKelas != $row[2] || $originalSemester != $row[4])) {
                            $this->createPengajuanIfNeeded($row, $jumlah_terlambat, $jumlah_alfa, $total);
                        }
                    } else {
                        $mahasiswa = MMahasiswa::create([
                            'kode_user' => $row[0],
                            'nama_user' => $row[1],
                            'kelas' => $row[2],
                            'prodi' => $row[3],
                            'semester' => $row[4],
                            'jumlah_terlambat' => $jumlah_terlambat,
                            'jumlah_alfa' => $jumlah_alfa,
                            'total' => $total,
                            'password' => Hash::make($row[0]),
                        ]);
                        $importedCount++;

                        if ($total == 0) {
                            $this->createPengajuanIfNeeded($row, $jumlah_terlambat, $jumlah_alfa, $total);
                        }
                    }
                }

                return redirect()->route('master.mahasiswa.listmahasiswa')->with('alert-success', 'Import data berhasil. Jumlah data berhasil diimpor: ' . $importedCount . ', Jumlah data berhasil diperbarui: ' . $updatedCount);
            } else {
                return redirect()->route('master.mahasiswa.listmahasiswa')->with('alert-error', 'File Excel tidak diunggah.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = 'Gagal menyimpan data. Kode user sudah ada dalam database. Kode user: ' . $e->errorInfo[2];
                \Log::error($errorMessage);
                return redirect()->route('master.mahasiswa.listmahasiswa')->with('alert-error', $errorMessage);
            } else {
                \Log::error('Gagal menyimpan data: ' . $e->getMessage());
                return redirect()->route('master.mahasiswa.listmahasiswa')->with('alert-error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
        }
    }

    private function createPengajuanIfNeeded($row, $jumlah_terlambat, $jumlah_alfa, $total)
    {
        $setupDataTerakhir = MSetupBertugas::orderBy('tgl_bertugas', 'desc')->take(3)->get();

        $approval1_by = $setupDataTerakhir->where('role', 'Pengawas')->first()->nama_user ?? null;
        $approval2_by = $setupDataTerakhir->where('role', 'PLP')->first()->nama_user ?? null;
        $approval3_by = $setupDataTerakhir->where('role', 'Kepala Lab')->first()->nama_user ?? null;

        if ($approval1_by && $approval2_by && $approval3_by) {
            $existingPengajuan = MPengajuan::where('kode_user', $row[0])
                ->where('kelas', $row[2])
                ->where('semester', $row[4])
                ->first();

            if (!$existingPengajuan) {
                $tbl_pengajuan = new MPengajuan();
                $tbl_pengajuan->kode_user = $row[0];
                $tbl_pengajuan->nama_user = $row[1];
                $tbl_pengajuan->kelas = $row[2];
                $tbl_pengajuan->prodi = $row[3];
                $tbl_pengajuan->semester = $row[4];
                $tbl_pengajuan->jumlah_terlambat = $jumlah_terlambat;
                $tbl_pengajuan->jumlah_alfa = $jumlah_alfa;
                $tbl_pengajuan->total = $total;

                $tbl_pengajuan->sisa = '0';
                $tbl_pengajuan->status_approval1 = 'Disetujui';
                $tbl_pengajuan->status_approval2 = 'Disetujui';
                $tbl_pengajuan->status_approval3 = 'Disetujui';
                $tbl_pengajuan->approval1_by = $approval1_by;
                $tbl_pengajuan->approval2_by = $approval2_by;
                $tbl_pengajuan->approval3_by = $approval3_by;

                $tbl_pengajuan->save();
            }
        }
    }

    public function mhswProfileShow(Request $request)
    {

        $user = Auth::guard('pmahasiswa')->user();

        return view('mahasiswa.profile.edit', ['dataMahasiswa' => $user]);
    }


    public function mhswProfileProsesEdit(Request $request)
    {
        $user = Auth::guard('pmahasiswa')->user();

        $form_kode_user = $request->input('kode_user');
        $form_nama_user = $request->input('nama_user');
        $form_email = $request->input('email');
        $form_notelp = $request->input('notelp');
        $form_new_password = $request->input('new_password');

        if ($user->nama_user === $form_nama_user) {
            // Update the user's details
            $user->kode_user = $form_kode_user;
            $user->nama_user = $form_nama_user;
            $user->email = $form_email;
            $user->notelp = $form_notelp;

            if (!empty($form_new_password)) {
                // Update the password if a new one is provided
                $user->password = bcrypt($form_new_password);
                $user->edit_password = '1';
            }

            $user->save();

            // Set success message
            Session::flash('alert-success', 'Berhasil Mengubah Data');
        } else {
            // Check if the new username already exists
            $usernameExists = MMahasiswa::where('nama_user', $form_nama_user)->exists();

            if ($usernameExists) {
                // Set error message if username already exists
                Session::flash('alert-error', 'OOPSSS! Nama User sudah ada!');
            } else {
                // Update the user's details
                $user->kode_user = $form_kode_user;
                $user->nama_user = $form_nama_user;
                $user->email = $form_email;
                $user->notelp = $form_notelp;

                if (!empty($form_new_password)) {
                    // Update the password if a new one is provided
                    $user->password = bcrypt($form_new_password);
                    $user->edit_password = '1';
                }

                $user->save();

                // Set success message
                Session::flash('alert-success', 'Berhasil Mengubah Data');
            }
        }

        // Redirect based on the user's role
        if ($user->role === 'Mahasiswa') {
            return redirect()->route('mahasiswa.listdata');
        }

        // Fallback redirection
        return redirect()->back();
    }

    public function forgetPasswordMhswShow(Request $request)
    {
        return view('forgetPasswordMhsw');
    }


    public function SendTokenMhsw(Request $request)
    {
        $request->validate(['kode_user' => 'required']);

        $user = MMahasiswa::where('kode_user', $request->kode_user)->first();

        if (!$user) {
            return response()->json(['error' => 'NIM not found'], 404);
        }

        $token = Str::random(12);

        $user->token = $token;
        $user->status_token = 0;

        $user->save();

        $nama_user = $user->nama_user;

        $mailData = [
            'title' => 'Hi, !, Kodemu Adalah: ',
            'body' => $token,
        ];

        try {
            Mail::to($user->email)->send(new resetPasswordMail($mailData));
        } catch (Exception $e) {
            // Tangani kesalahan pengiriman email di sini
            Log::error('Kesalahan pengiriman email: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Token sent to your email']);
    }

    public function ValidasiTokenMhsw(Request $request)
    {
        $form_kode_user = $request->post('kode_user');
        $form_token = $request->post('token');
        // dd($form_NIM);

        $user = MMahasiswa::where('kode_user', $form_kode_user)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $tokenUser = $user->token;
        $statusToken = $user->status_token;

        // dd($form_token, $tokenUser);

        if ($form_token === $tokenUser) {
            if ($statusToken === 0) {
                Session::put('kode_user', $form_kode_user);
                Session::flash('alert-success', 'Berhasil Reset Password');
                return redirect()->route('resetPasswordMhsw');
            } else {
                Session::flash('alert-error', 'kode Anda Sudah Digunakan, Silahkan Request Kode Baru');
                return redirect()->route('forgetPasswordUser');
            }
        } else {
            Session::flash('alert-error', 'kode salah');
            return redirect()->route('forgetPasswordMhsw');
            // return response()->json(['success' => false, 'message' => 'ga cocok'], 404);
        }
    }
    public function resetPasswordMhswShow(Request $request)
    {
        $kode_user = Session::get('kode_user');

        if (!$kode_user) {
            return redirect()->route('forgetPasswordMhsw')->with('error-alert',   'NIM tidak ditemukan');
        }
        return view('resetPasswordMhsw', compact('kode_user'));
    }

    public function ResetPasswordMhswProses(Request $request)
    {
        $form_password_baru = $request->post('new_password');
        $form_konfirmasi_password = $request->post('confirm_password');
        $hashedPassword = bcrypt($form_password_baru); // Hash password baru, bukan konfirmasi password
        $form_kode_user = $request->post('kode_user');
        // dd($form_password_baru, $form_konfirmasi_password,$form_NIM);

        if ($form_password_baru === $form_konfirmasi_password) {
            $user = MMahasiswa::where('kode_user', $form_kode_user)->first();

            if ($user) {
                $user->password = $hashedPassword;
                $user->status_token = 1;
                $user->save();
                Session::flash('alert-success', 'Berhasil Reset Password');
                return redirect()->route('loginmhsw');
            } else {
                Session::flash('alert-error', 'User dengan NIM tersebut tidak ditemukan');
            }
        } else {
            Session::flash('alert-error', 'Password Tidak Cocok');
        }

        return redirect()->route('forgetPasswordMhsw');
    }
}

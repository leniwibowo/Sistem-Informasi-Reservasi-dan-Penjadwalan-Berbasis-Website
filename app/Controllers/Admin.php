<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\AdminModel;
use App\Models\JadwalModel;
use App\Models\AntrianModel;
use App\Models\JadwalDokterModel;
use App\Models\UserModel;
use App\Models\RiwayatModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use CodeIgniter\Commands\Utilities\Publish;

class Admin extends BaseController
{

    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;
    protected $dokterModel;
    protected $userModel;
    protected $riwayatModel;
    protected $adminModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
        $this->userModel = new UserModel();
        $this->riwayatModel = new RiwayatModel();
        $this->adminModel = new AdminModel();
    }

    // dashboard
    public function index()
    {
        //  antrian Hari Ini (menggunakan antrianModel agar lebih akurat)
        $antrian_hari_ini = $this->antrianModel->where('tanggal', date('Y-m-d'))->countAllResults();
        $antrian_menunggu = $this->antrianModel->where('tanggal', date('Y-m-d'))->where('status', 'Menunggu')->countAllResults();
        $antrian_selesai = $this->antrianModel->where('tanggal', date('Y-m-d'))->whereIn('status', ['Selesai', 'Diperiksa'])->countAllResults();

        //  total pengguna ambil dari pasienModel, dokterModel, adminModel
        $total_pasien = $this->pasienModel->countAllResults();
        $total_dokter = $this->dokterModel->countAllResults();
        $total_admin = $this->adminModel->countAllResults();

        //  data daftar pasien
        //  mengambil 5 pasien yang baru saja mendaftar dari pasienModel
        $pasien_terbaru = $this->pasienModel->orderBy('created_at', 'DESC')->limit(5)->find();

        // mengambil 5 jadwal kunjungan hari ini dari jadwalModel
        $jadwal_hari_ini = $this->jadwalModel->getFullJadwalHariIni(5);


        // data yang tampil di dashboard admin
        $data = [
            'title'                 => 'Dashboard Admin',
            // data tampil dashboard
            'antrian_hari_ini'      => $antrian_hari_ini,
            'antrian_menunggu'      => $antrian_menunggu,
            'antrian_selesai'       => $antrian_selesai,
            'total_pasien'          => $total_pasien,
            'total_dokter'          => $total_dokter,
            'total_admin'           => $total_admin,
            // data daftar
            'pasien_terbaru'        => $pasien_terbaru,
            'jadwal_hari_ini'       => $jadwal_hari_ini,
        ];

        return view('admin/dashboard', $data);
    }


    // LOGIKA UNTUK ANTRIAN DIHALAMAN ADMIN
    // Fungsi Antrian
    public function Antrian()
    {
        $session = session();
        if ($session->get('role') != 'admin') {
            return redirect()->to('/login')->with('error', 'Silahkan login sebagai admin.');
        };

        // fungsi hanya untuk mendapatkan pasien yang 'Menunggu' ambil dari antrianModel
        $pasienMenunggu = $this->antrianModel->getAntrianHariIni();

        return view('/admin/antrian', [
            'pasienTerdaftar' => $pasienMenunggu
        ]);
    }

    // fungsi untuk pasien yang sedang melakukan pemeriksaan
    public function periksa($id_antrian)
    {
        // periksa apakah ada id_antrian
        if (!$id_antrian) {
            return redirect()->back()->with('error', 'ID antrian tidak valid.');
        }

        // ambil data antrian dari antrianModel
        $antrian = $this->antrianModel->find($id_antrian);

        // pastikan antrian ditemukan dan statusnya masih 'Menunggu'
        if (!$antrian || $antrian['status'] !== 'Menunggu') {
            return redirect()->back()->with('error', 'Antrian tidak valid atau sudah diperiksa.');
        }

        // ubah status antrian menjadi 'Diperiksa' update dari antrianModel
        $this->antrianModel->update($id_antrian, ['status' => 'Diperiksa']);

        return redirect()->to('/admin/antrian')->with('success', 'Status antrian berhasil diperbarui menjadi diperiksa.');
    }

    // fungsi saat pasien telah selesai dipriksa
    public function selesai($id_antrian)
    {
        // cek apakah ID antrian valid
        if (!$id_antrian) {
            return redirect()->back()->with('error', 'ID antrian tidak valid.');
        }

        // ambil data antrian untuk validasi dari antraianModel
        $antrian = $this->antrianModel->find($id_antrian);

        // pastikan antrian ditemukan dan statusnya masih 'Diperiksa'
        if (!$antrian || $antrian['status'] !== 'Diperiksa') {
            return redirect()->back()->with('error', 'Antrian tidak valid atau belum diperiksa.');
        }

        // perbarui status antrian menjadi 'Selesai' update datei antrianModel
        $this->antrianModel->update($id_antrian, ['status' => 'Selesai']);

        return redirect()->to('/admin/antrian')->with('success', 'Pemeriksaan pasien telah selesai.');
    }

    // fungsi untuk melewati pasien yang tidak hadir
    public function lewati($id_antrian)
    {
        // data untuk diupdate: isi kolom urutan_panggil dengan waktu sekarang.
        $data = [
            'urutan_panggil' => date('Y-m-d H:i:s')
        ];

        // Lakukan update pada database dari antrian model
        $this->antrianModel->update($id_antrian, $data);

        // Kembali ke halaman antrian
        return redirect()->to('/admin/antrian')->with('info', 'Pasien telah dilewati.');
    }


    // mengambil data pasien detail
    public function detail($id_pasien)
    {
        $pasienModel = new \App\Models\PasienModel();

        // Panggil fungsi kustom yang baru dibuat dari pasienModel
        $data_pasien = $pasienModel->getDetailPasien($id_pasien);
    }


    // LOGIKA UNTUK KELOLA DATA PASIEN (ADMIN)
    public function kelolaPasien()
    {
        // mendefinisikan keyword untuk mencari nama atau no_antrian dari pasienModel
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $pasien = $this->pasienModel
                ->like('nama', $keyword)
                ->orLike('no_RM', $keyword)
                ->findAll();
        } else {
            $pasien = $this->pasienModel->findAll();
        }
        return view('admin/kelolapasien', [
            'title' => 'Kelola Data Pasien',
            'pasien' => $pasien
        ]);
    }

    // LOGIKA TAMBAH PASIEN (ADMIN)
    public function tambahPasien()
    {
        return view('admin/tambahpasien', [
            'title' => 'Tambah Pasien'
        ]);
    }
    // LOGIKA SIMPAN PASIEN (ADMIN

    public function simpanPasien()
    {
        // mendefiniskan Aturan Validasi
        $rules = [
            'nik' => [
                'rules'  => 'required|exact_length[16]|numeric|is_unique[pasien.nik]',
                'errors' => [
                    'required'      => 'NIK wajib diisi.',
                    'exact_length'  => 'NIK harus terdiri dari 16 digit angka.',
                    'numeric'       => 'NIK hanya boleh berisi angka.',
                    'is_unique'     => 'NIK ini sudah terdaftar.'
                ]
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama lengkap wajib diisi.']
            ],
            'tanggal_lahir' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal lahir wajib diisi.',
                    'valid_date' => 'Format tanggal lahir tidak valid.'
                ]
            ],
            'no_hp' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'numeric'  => 'Nomor telepon hanya boleh berisi angka.'
                ]
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat wajib diisi.']
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[laki-laki,perempuan]',
                'errors' => ['required' => 'Jenis kelamin wajib dipilih.']
            ],
            'golongan_darah' => [
                'rules'  => 'required|in_list[A,B,AB,O]',
                'errors' => ['required' => 'Golongan darah wajib dipilih.']
            ],
            'alergi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Riwayat alergi wajib diisi.']
            ],
            'diabetes' => [
                'rules'  => 'required|in_list[ya,tidak]',
                'errors' => ['required' => 'Riwayat diabetes wajib dipilih.']
            ],
            'penyakit_jantung' => [
                'rules'  => 'required|in_list[ya,tidak]',
                'errors' => ['required' => 'Riwayat penyakit jantung wajib dipilih.']
            ],
            'username' => [
                'rules'  => 'required|is_unique[users.username]',
                'errors' => [
                    'required'  => 'Username wajib diisi.',
                    'is_unique' => 'Username ini sudah digunakan.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal harus 5 karakter.'
                ]
            ]
        ];

        // menjalankan validasi
        if (!$this->validate($rules)) {
            // validasi gagal, kembalikan ke form dengan error dan input lama
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // validasi berhasil, lanjutkan proses

        // transaksi untuk menjaga konsistensi data
        $this->db->transStart();

        //  membuat akun pengguna baru (users) 
        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pasien'
        ]);
        $idUser = $this->userModel->getInsertID();

        // membuat nomor RM otomatis
        $lastPasien = $this->pasienModel->orderBy('id_pasien', 'DESC')->first();
        if ($lastPasien) {
            $lastRM = intval(substr($lastPasien['no_RM'], 2));
            $newRM = 'RM' . str_pad($lastRM + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newRM = 'RM0001';
        }

        //  simpan data pasien ke tabel 'pasien' pasienModel
        $this->pasienModel->insert([
            'nik'               => $this->request->getPost('nik'),
            'nama'              => $this->request->getPost('nama'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'no_hp'             => $this->request->getPost('no_hp'),
            'alamat'            => $this->request->getPost('alamat'),
            'tanggal_lahir'     => $this->request->getPost('tanggal_lahir'),
            'alergi'            => $this->request->getPost('alergi'),
            'golongan_darah'    => $this->request->getPost('golongan_darah'),
            'penyakit_jantung'  => $this->request->getPost('penyakit_jantung'),
            'diabetes'          => $this->request->getPost('diabetes'),
            'no_RM'             => $newRM,
            'id_user'           => $idUser,
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            // jika transaksi gagal
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }

        return redirect()->to('/admin/kelolapasien')->with('success', 'Data pasien baru berhasil ditambahkan.');
    }

    // LOGIKA EDIT PASIEN (ADMIN)
    public function editPasien($id)
    {
        $pasien = $this->pasienModel->find($id);
        return view('admin/editpasien', [
            'title' => 'Edit Pasien',
            'pasien' => $pasien
        ]);
    }

    // LOGIKA UPDATE PASIEN SETELAH MENGEDIT (ADMIN)
    public function updatePasien($id)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'alergi' => $this->request->getPost('alergi'),
            'golongan_darah' => $this->request->getPost('golongan_darah'),
            'penyakit_jantung' => $this->request->getPost('penyakit_jantung'),
            'diabetes' => $this->request->getPost('diabetes'),
        ];

        // optional: jika username boleh diubah
        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        }

        // optional: jika password boleh diubah
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->pasienModel->update($id, $data);
        return redirect()->to('/admin/kelolapasien')->with('success', 'Data pasien berhasil diubah.');
    }
    // profil pasien
    public function profil_pasien($id_pasien)
    {
        // Panggil model Pasien
        $pasienModel = new \App\Models\PasienModel();

        // Cari data pasien berdasarkan ID yang didapat dari URL
        $data['pasien'] = $pasienModel->find($id_pasien);

        // Jika data pasien tidak ditemukan, tampilkan error 404
        if (!$data['pasien']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data Pasien tidak ditemukan.');
        }

        // Jika data ditemukan, tampilkan view profil dengan data tersebut
        return view('admin/profil_pasien', $data);
    }


    // LOGIKA UNTUK MENGHAPUS DATA PASIEN
    public function hapusPasien($id)
    {
        $pasien = $this->pasienModel->find($id);

        if ($pasien) {
            // ambil 'id_user' dari data pasien sebelum dihapus
            $userIdToDelete = $pasien['id_user'];

            // uapus data dari tabel 'pasien' 
            // (otomatis menghapus 'jadwal' dan 'riwayat_pemeriksaan')
            $this->pasienModel->delete($id);

            // hapus data dari tabel 'users' menggunakan ID yang sudah disimpan
            if ($userIdToDelete) {
                //h=apus user secara permanen (purge) berdasarkan ID-nya
                $this->userModel->delete($userIdToDelete, true);
            }

            return redirect()->to('/admin/kelolapasien')->with('success', 'Data pasien dan akun user terkait berhasil dihapus.');
        } else {
            return redirect()->to('/admin/kelolapasien')->with('error', 'Data pasien tidak ditemukan.');
        }
    }


    // LOGIKA HALAMAN RIWAYAT PEMERIKSAAN PASIEN (ADMIN)
    public function riwayatPemeriksaanPasien($id_pasien)
    {
        $riwayatModel = new RiwayatModel();
        $pasienModel = new PasienModel();

        // ambil dari riwayatModel
        $riwayat = $riwayatModel->getRiwayatByPasien($id_pasien);
        $pasien = $pasienModel->find($id_pasien);

        return view('admin/riwayatpemeriksaan', [
            'title' => 'Riwayat Pemeriksaan',
            'riwayat' => $riwayat,
            'pasien' => $pasien
        ]);
    }

    //  LOGIKA KELOLA DATA DOKTER (ADMIN)
    public function kelolaDokter()
    {
        // mendefifisikan keyowrd untuk mencari nama dokter 
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $dokter = $this->dokterModel
                ->like('nama', $keyword)
                ->findAll();
        } else {
            $dokter = $this->dokterModel->findAll();
        }
        return view('admin/keloladokter', [
            'title' => 'Kelola Data Dokter',
            'dokter' => $dokter
        ]);
    }

    // LOGIKA TAMBAH DOKTER (ADMIN)
    public function tambahDokter()
    {
        return view('admin/tambahdokter', [
            'title' => 'Tambah Dokter'
        ]);
    }

    // LOGIKA SIMPAN DOKTER (ADMIN)
    public function simpanDokter()
    {
        // ambil data dari form
        $dataUser = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'dokter'
        ];

        // pstikan data user hanya disimpan sekali
        $this->userModel->insert($dataUser);
        $idUser = $this->userModel->getInsertID();  // Mengambil ID user yang baru disimpan

        log_message('debug', 'ID User yang baru disimpan: ' . $idUser);

        // Data dokter
        $dataDokter = [
            'nama'    => $this->request->getPost('nama'),
            'no_hp'   => $this->request->getPost('no_hp'),
            'username'   => $this->request->getPost('username'),
            'password'   => $this->request->getPost('password'),
            'id_user' => $idUser  // Menyertakan ID user yang baru disimpan
        ];

        log_message('debug', 'Data Dokter yang akan disimpan: ' . print_r($dataDokter, true));

        // insert data dokter
        if ($this->dokterModel->insert($dataDokter)) {
            return redirect()->to('/admin/keloladokter')->with('success', 'Dokter berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan dokter');
        }
    }

    // LOGIKA EDIT DOKTER
    public function editDokter($id)
    {
        $dokter = $this->dokterModel->find($id);
        return view('admin/editdokter', [
            'title' => 'Edit Dokter',
            'dokter' => $dokter
        ]);
    }

    // LOGIKA UNTUK UPDATE DATA DOKTER (ADMIN)
    public function updateDokter($id)
    {

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'no_hp'    => $this->request->getPost('no_hp'),
            'username' => $this->request->getPost('username'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }


        $this->dokterModel->update($id, $data);

        return redirect()->to('/admin/keloladokter')->with('success', 'Data dokter berhasil diubah.');
    }


    // LOGIKA HAPUS DATA DOKTER (ADMIN)
    public function hapusDokter($id)
    {
        // mengambil data dokter berdasarkan ID
        $dokter = $this->dokterModel->find($id);

        if ($dokter) {
            // hapus dari tabel dokter
            $this->dokterModel->delete($id);

            // hpus juga dari tabel users berdasarkan username yang sama
            $this->userModel->where('username', $dokter['username'])->delete(null, true);


            return redirect()->to('/admin/keloladokter')->with('success', 'Data dokter berhasil dihapus.');
        } else {
            return redirect()->to('/admin/keloladokter')->with('error', 'Data dokter tidak ditemukan.');
        }
    }

    // kelola jadwal dokter
    public function kelolaJadwalDokter()
    {
        // model JadwalDokterModel
        $jadwalDokterModel = new \App\Models\JadwalDokterModel();

        // ambil semua jadwal yang sudah di-join dengan nama dokter dari jadwakDokterModel
        $jadwal_dokter = $jadwalDokterModel->getJadwalWithDokter();

        // ambil semua data dokter untuk ditampilkan di form tambah
        $dokter_list = $this->dokterModel->orderBy('nama', 'ASC')->findAll();

        $data = [
            'title'         => 'Kelola Jadwal Praktik Dokter',
            'jadwal_dokter' => $jadwal_dokter,
            'dokter_list'   => $dokter_list
        ];

        return view('admin/kelolajadwaldokter', $data);
    }


    // simpan data dokter yang baru
    public function simpanJadwalDokter()
    {
        // validasi input
        $rules = [
            'id_dokter' => 'required|is_natural_no_zero',
            'hari'      => 'required|in_list[Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data yang Anda masukkan tidak valid.');
        }

        $id_dokter = $this->request->getPost('id_dokter');
        $hari = $this->request->getPost('hari');

        // cek duplikat jadwal dari jadwalDokterModel 
        $jadwalDokterModel = new \App\Models\JadwalDokterModel();
        $jadwalSudahAda = $jadwalDokterModel->where('id_dokter', $id_dokter)
            ->where('hari', $hari)
            ->first();

        if ($jadwalSudahAda) {
            return redirect()->back()->withInput()->with('error', 'Jadwal untuk dokter ini pada hari tersebut sudah ada.');
        }

        // simpan data baru
        $jadwalDokterModel->save([
            'id_dokter' => $id_dokter,
            'hari'      => $hari
        ]);

        return redirect()->to('/admin/kelolajadwal')->with('success', 'Jadwal dokter berhasil ditambahkan.');
    }

    // hapus data dokter
    public function hapusJadwalDokter($id_jadwal_dokter)
    {
        $jadwalDokterModel = new \App\Models\JadwalDokterModel();

        // cari jadwal berdasarkan id dari jadwalDokterModel
        $jadwal = $jadwalDokterModel->find($id_jadwal_dokter);

        if ($jadwal) {
            $jadwalDokterModel->delete($id_jadwal_dokter);
            return redirect()->to('/admin/kelolajadwal')->with('success', 'Jadwal dokter berhasil dihapus.');
        } else {
            return redirect()->to('/admin/kelolajadwal')->with('error', 'Jadwal tidak ditemukan.');
        }
    }

    // LOGIKA KELOLA DATA ADMIN
    public function kelolaAdmin()
    {

        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $admin = $this->adminModel
                ->like('nama', $keyword)
                ->findAll();
        } else {
            $admin = $this->adminModel->findAll();
        }
        return view('admin/kelolaadmin', [
            'title' => 'Kelola Data Admin',
            'admin' => $admin
        ]);
    }

    // LOGIKA TAMBAH DOKTER (ADMIN)
    public function tambahAdmin()
    {
        return view('admin/tambahadmin', [
            'title' => 'Tambah Admin'
        ]);
    }
    // LOGIKA SIMPAN admin (ADMIN)
    public function simpanAdmin()
    {
        // data untuk tabel 'users'
        $dataUser = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'admin'
        ];

        // simpan ke user priksa, jika gagal error
        if ($this->userModel->insert($dataUser) === false) {

            dd($this->userModel->errors());
        }

        // jika insert user berhasil, lanjutkan
        $idUser = $this->userModel->getInsertID();

        // data untuk tabel 'admin'
        $dataAdmin = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $dataUser['password'],
            'id_user'  => $idUser
        ];

        // coba simpan ke 'admin'
        if ($this->adminModel->insert($dataAdmin)) {
            return redirect()->to('/admin/kelolaadmin')->with('success', 'Admin berhasil ditambahkan');
        } else {
            // jika insert admin yang gagal, tampilkan errornya
            dd($this->adminModel->errors());
        }
    }


    // LOGIKA EDIT ADMIN
    public function editAdmin($id)
    {
        // ambil dari adminModel 
        $admin = $this->adminModel->find($id);

        if (!$admin) {
            return redirect()->to('/admin/kelolaadmin')->with('error', 'Admin tidak ditemukan.');
        }

        return view('admin/editadmin', ['admin' => $admin]);
    }

    // LOGIKA UNTUK UPDATE DATA DOKTER (ADMIN)
    public function updateAdmin($id)
    {

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }


        $this->adminModel->update($id, $data);

        return redirect()->to('/admin/kelolaadmin')->with('success', 'Data dokter berhasil diubah.');
    }

    // LOGIKA HAPUS DATA ADMIN (ADMIN)
    public function hapusAdmin($id)
    {
        // ambil data dokter berdasarkan ID
        $admin = $this->adminModel->find($id);

        if ($admin) {
            // hapus dari tabel dokter
            $this->adminModel->delete($id);

            // Hhpus juga dari tabel users berdasarkan username yang sama
            $this->userModel->where('username', $admin['username'])->delete();

            return redirect()->to('/admin/kelolaadmin')->with('success', 'Data admin berhasil dihapus.');
        } else {
            return redirect()->to('/admin/kelolaadmin')->with('error', 'Data admin tidak ditemukan.');
        }
    }

    // profil admin
    public function profil()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai admin.');
        }

        $userId = session()->get('id_user'); // pakai id_user, BUKAN id_admin
        $admin = $this->adminModel->where('id_user', $userId)->first(); // cari admin berdasarkan id_user

        if (!$admin) {
            return redirect()->to('/dashboard')->with('error', 'Data admin tidak ditemukan.');
        }

        return view('admin/profil', [
            'title' => 'Profil Admin',
            'admin' => $admin
        ]);
    }

    // Untuk halaman mecari pasien
    public function pasienTerjadwal()
    {
        $keyword = $this->request->getGet('keyword');
        $pasien = [];

        if ($keyword) {
            $pasien = $this->pasienModel
                ->like('nama', $keyword)
                ->orLike('no_RM', $keyword)
                ->findAll();
        }

        // ambil daftar pasien yang sudah dijadwalkan dari hari ini ke depan
        $jadwalAkanDatang = $this->jadwalModel->getJadwalAkanDatang();

        return view('admin/pasienterjadwal', [
            'pasien' => $pasien,
            'jadwal_akan_datang' => $jadwalAkanDatang, // <-- Kirim data baru ke view
        ]);
    }


    // mencari data dokter berdasarkan tanggal
    public function apiGetDokterByJadwal()
    {
        $tanggal = $this->request->getGet('tanggal');
        if (!$tanggal) {
            return $this->response->setJSON(['error' => 'Parameter tanggal dibutuhkan.'])->setStatusCode(400);
        }

        $jadwalDokterModel = new \App\Models\JadwalDokterModel();
        $dokterTersedia = $jadwalDokterModel->getDokterByTanggal($tanggal);

        return $this->response->setJSON($dokterTersedia);
    }
    // app/Controllers/Admin.php


    // FUNGSI UNTUK MENAMPILKAN PASIEN TERJADWAL
    public function jadwalPercobaan()
    {
        return view('admin/jadwal_percobaan');
    }

    // FUNGSI UNTUK MENERIMA DATA DARI FORM PERCOBAAN DAN MENYIMPAN KE DB
    public function simpanJadwalPercobaan()
    {
        // validasi Input Form 
        $rules = [
            'id_pasien'           => 'required|is_natural_no_zero',
            'tanggal_pemeriksaan' => 'required|valid_date',
            'id_dokter'           => 'required|is_natural_no_zero',
            'pemeriksaan'         => 'permit_empty|string'
        ];
        if (!$this->validate($rules)) {
            // jika validasi gagal, kembalikan ke form dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        $pasienModel = new \App\Models\PasienModel();
        $jadwalModel = new \App\Models\JadwalModel();
        $antrianModel = new \App\Models\AntrianModel();

        // ambil data dari POST 
        $id_pasien = $this->request->getPost('id_pasien');
        $tanggal = $this->request->getPost('tanggal_pemeriksaan');
        $id_dokter = $this->request->getPost('id_dokter');

        // cek apakah pasien ada 
        $pasien = $pasienModel->find($id_pasien);
        if (!$pasien) {
            return redirect()->back()->withInput()->with('error', 'Data Pasien tidak ditemukan.');
        }

        // cek jadwal duplikat 
        $jadwalSudahAda = $jadwalModel
            ->where('id_pasien', $id_pasien)
            ->where('tanggal_pemeriksaan', $tanggal)
            ->whereIn('status', ['belum_hadir', 'Menunggu'])
            ->first();

        if ($jadwalSudahAda) {
            return redirect()->back()->withInput()->with('error', 'Pasien ini sudah memiliki jadwal aktif pada tanggal yang dipilih.');
        }

        // mulai Transaksi Database 
        $db = \Config\Database::connect();
        $db->transStart();

        // simpan ke tabel 'jadwal'
        $dataJadwal = [
            'id_pasien'           => $id_pasien,
            'id_dokter'           => $id_dokter,
            'tanggal_pemeriksaan' => $tanggal,
            'pemeriksaan'         => $this->request->getPost('pemeriksaan'),
            'status'              => 'belum_hadir',
        ];
        $jadwalModel->save($dataJadwal);
        $idJadwalBaru = $jadwalModel->getInsertID();

        // generate nomor antrian
        $jumlahAntrianSebelumnya = $antrianModel
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->where('jadwal.id_dokter', $id_dokter)
            ->where('antrian.tanggal', $tanggal)
            ->countAllResults();
        $nomorAntrianBaru = $jumlahAntrianSebelumnya + 1;

        // simpan ke tabel 'antrian'
        $dataAntrian = [
            'id_pasien'      => $id_pasien,
            'id_jadwal'      => $idJadwalBaru,
            'tanggal'        => $tanggal,
            'no_antrian'     => $nomorAntrianBaru,
            'no_RM'          => $pasien['no_RM'],
            'keluhan'        => $this->request->getPost('pemeriksaan'),
            'status'         => 'Menunggu',
            'urutan_panggil' => $nomorAntrianBaru,
        ];
        $antrianModel->save($dataAntrian);

        // selesaikan transaksi
        $db->transComplete();

        // kirim response berdasarkan status transaksi
        if ($db->transStatus() === false) {
            // transaksi gagal, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada database. Gagal menyimpan jadwal.');
        } else {

            // transaksi berhasil, set flash data dan redirect
            $successMessage = 'Jadwal pasien berhasil disimpan dengan nomor antrian ' . $nomorAntrianBaru . '.';

            return redirect()->to('/admin/pasienterjadwal')
                ->with('success', $successMessage);
        }
    }

    // API UNTUK MENGAMBIL SEMUA PASIEN (UNTUK DROPDOWN)
    public function apiGetAllPasien()
    {
        $pasienModel = new PasienModel();
        $pasien = $pasienModel->select('id_pasien, nama, no_RM')->orderBy('no_RM', 'ASC')->findAll();
        return $this->response->setJSON($pasien);
    }

    // donwload data pasien
    public function download()
    {
        $pasienModel = new PasienModel();
        $data = $pasienModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul kolom
        $sheet->setCellValue('A1', 'No RM');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'No HP');
        $sheet->setCellValue('D1', 'Alamat');
        $sheet->setCellValue('E1', 'Tanggal Lahir');

        // Isi data
        $row = 2;
        foreach ($data as $p) {
            $sheet->setCellValue('A' . $row, $p['no_RM']);
            $sheet->setCellValue('B' . $row, $p['nama']);
            $sheet->setCellValue('C' . $row, $p['no_hp']);
            $sheet->setCellValue('D' . $row, $p['alamat']);
            $sheet->setCellValue('E' . $row, $p['tanggal_lahir']);
            $row++;
        }

        $filename = 'Data_Pasien_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

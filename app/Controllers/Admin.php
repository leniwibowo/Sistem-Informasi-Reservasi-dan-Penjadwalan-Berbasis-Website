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

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
        $this->userModel = new UserModel();
        $this->riwayatModel = new RiwayatModel();
        $this->adminModel = new AdminModel();
    }
    public function index()
    {
        $userID = session()->get('id_user');

        $antrian = $this->jadwalModel
            ->where('tanggal_pemeriksaan', date('Y-m-d'))
            ->countAllResults();

        // mengambil total antrian (misal: pasien yang belum hadir)
        $sisa_antrian = $this->jadwalModel
            ->where('tanggal_pemeriksaan', date('Y-m-d'))
            ->where('status', 'belum_hadir')
            ->countAllResults();

        // menghitung seluruh pasien
        $total_pasien = $this->pasienModel->countAllResults();

        return view('admin/dashboard', [
            'antrian' => $antrian,
            'sisa_antrian' => $sisa_antrian,
            'total_pasien' => $total_pasien,

        ]);
    }

    // LOGIKA UNTUK ANTRIAN DIHALAMAN ADMIN
    public function Antrian()
    {

        $session = session();
        if ($session->get('role') != 'admin') {
            return redirect()->to('/login')->with('error', 'Silahkan login sebagai admin.');
        };

        $pasinTerdaftar = $this->antrianModel->getAntrianHariIni();


        return view('/admin/antrian', [
            'pasienTerdaftar' => $pasinTerdaftar
        ]);
    }

    public function lewati($id_antrian)
    {
        $antrianModel = new \App\Models\AntrianModel();

        // Update status menjadi Tidak Hadir
        $antrianModel->update($id_antrian, [
            'status' => 'Tidak Hadir'
        ]);

        return redirect()->to('/admin/antrian')->with('success', 'Pasien telah dilewati.');
    }

    // LOGIKA UNTUK KELOLA DATA PASIEN (ADMIN)

    public function kelolaPasien()
    {
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
    // LOGIKA SIMPAN PASIEN (ADMIN)
    public function simpanPasien()
    {
        $data = [
            'nik' => $this->request->getPost('nik'),
            'no_RM' => $this->request->getPost('no_RM'),
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alergi' => $this->request->getPost('alergi'),
            'golongan_darah' => $this->request->getPost('golongan_darah'),
            'penyakit_jantung' => $this->request->getPost('penyakit_jantung'),
            'diabetes' => $this->request->getPost('diabetes'),
        ];

        $this->pasienModel->insert($data);
        return redirect()->to('/admin/kelolapasien')->with('success', 'Data pasien berhasi ditambahkan.');
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

        // Optional: Jika username boleh diubah
        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        }

        // Optional: Jika password boleh diubah
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->pasienModel->update($id, $data);
        return redirect()->to('/admin/kelolapasien')->with('success', 'Data pasien berhasil diubah.');
    }

    // LOGIKA UNTUK MENGHAPUS DATA PASIEN

    public function hapusPasien($id)
    {
        $pasien = $this->pasienModel->delete($id);
        if ($pasien) {

            // Hapus juga dari tabel users berdasarkan username yang sama
            $this->userModel->where('username', $pasien['username'])->delete();

            return redirect()->to('/admin/kelolapasien')->with('success', 'Data dokter berhasil dihapus.');
        } else {
            return redirect()->to('/admin/kelolapasien')->with('error', 'Data dokter tidak ditemukan.');
        }
    }

    // LOGIKA HALAMAN RIWAYAT PEMERIKSAAN PASIEN (ADMIN)

    public function riwayatPemeriksaanPasien($id_pasien)
    {
        $riwayatModel = new RiwayatModel();
        $pasienModel = new PasienModel();

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
        // Ambil data dari form
        $nama = $this->request->getPost('nama');
        $no_hp = $this->request->getPost('no_hp');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke tabel dokter
        $this->dokterModel->insert([
            'nama' => $nama,
            'no_hp' => $no_hp,
            'username' => $username,
            'password' => $hashedPassword
        ]);

        // Simpan juga ke tabel users agar bisa login
        $this->userModel->insert([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => 'dokter'
        ]);

        return redirect()->to('/admin/keloladokter')->with('success', 'Dokter berhasil ditambahkan dan bisa login.');
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
        // Ambil data dokter berdasarkan ID
        $dokter = $this->dokterModel->find($id);

        if ($dokter) {
            // Hapus dari tabel dokter
            $this->dokterModel->delete($id);

            // Hapus juga dari tabel users berdasarkan username yang sama
            $this->userModel->where('username', $dokter['username'])->delete();

            return redirect()->to('/admin/keloladokter')->with('success', 'Data dokter berhasil dihapus.');
        } else {
            return redirect()->to('/admin/keloladokter')->with('error', 'Data dokter tidak ditemukan.');
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
    // LOGIKA SIMPAN DOKTER (ADMIN)
    public function simpanAdmin()
    {
        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek apakah semua data ada
        if (!$nama || !$username || !$password) {
            return redirect()->back()->with('error', 'Data tidak lengkap!');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke tabel admin
        $this->adminModel->insert([
            'nama'     => $nama,
            'username' => $username,
            'password' => $hashedPassword
        ]);

        // Simpan ke tabel users
        $this->userModel->insert([
            'username' => $username,
            'password' => $hashedPassword,
            'role'     => 'admin'
        ]);

        return redirect()->to('/admin/kelolaadmin')->with('success', 'Admin berhasil ditambahkan.');
    }





    // LOGIKA EDIT DOKTER
    public function editAdmin($id)
    {
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
    // LOGIKA HAPUS DATA DOKTER (ADMIN)
    public function hapusAdmin($id)
    {
        // Ambil data dokter berdasarkan ID
        $admin = $this->adminModel->find($id);

        if ($admin) {
            // Hapus dari tabel dokter
            $this->adminModel->delete($id);

            // Hapus juga dari tabel users berdasarkan username yang sama
            $this->userModel->where('username', $admin['username'])->delete();

            return redirect()->to('/admin/kelolaadmin')->with('success', 'Data dokter berhasil dihapus.');
        } else {
            return redirect()->to('/admin/kelolaadmin')->with('error', 'Data dokter tidak ditemukan.');
        }
    }



    // Untuk halaman mecari pasien

    public function pasienTerjadwal()
    {
        $pasienModel = new PasienModel();
        $keyword = $this->request->getGet('keyword');
        $pasien = [];

        if ($keyword) {
            $pasien = $pasienModel
                ->like('nama', $keyword)
                ->orLike('no_RM', $keyword)
                ->findAll();
        }
        return view('admin/pasienterjadwal', [
            'pasien' => $pasien,
        ]);
    }

    // Untuk halaman input jadwal pasien
    public function tambahJadwalPasien($id_pasien)
    {
        $pasienModel = new PasienModel();
        $jadwalDokterModel = new JadwalDokterModel();
        $jadwalModel = new JadwalModel();

        $pasien = $pasienModel->find($id_pasien);

        if ($this->request->getMethod() === 'post') {
            $tanggal = $this->request->getPost('tanggal_pemeriksaan');
            $id_dokter = $this->request->getPost('id_dokter');
            $pemeriksaan = $this->request->getPost('pemeriksaan');

            $jadwalModel->insert([
                'id_pasien' => $id_pasien,
                'id_dokter' => $id_dokter,
                'tanggal_pemeriksaan' => $tanggal,
                'pemeriksaan' => $pemeriksaan,
                'status' => 'terjadwal',
            ]);

            return redirect()->to('admin/pasienterjadwal')->with('success', 'Pasien berhasil dijadwalkan');
        }

        $dokter = [];
        if ($this->request->getGet('tanggal')) {
            $tanggal = $this->request->getGet('tanggal');
            $dokter = $jadwalDokterModel->getDokterByTanggal($tanggal);
        }

        return view('admin/tambah_jadwal_pasien', [
            'pasien' => $pasien,
            'dokter' => $dokter,
            'tanggal' => $tanggal ?? ''
        ]);
    }

    public function profil()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai admin.');
        }

        $userId = session()->get('id_admin'); // GANTI SESUAI YANG KAMU SIMPAN DI SESSION
        $admin = $this->adminModel->find($userId);

        if (!$admin) {
            return redirect()->to('/dashboard')->with('error', 'Data admin tidak ditemukan.');
        }

        return view('admin/profil', [
            'title' => 'Profil Admin',
            'admin' => $admin
        ]);
    }
}

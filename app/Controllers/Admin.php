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
use CodeIgniter\Commands\Utilities\Publish;

class Admin extends BaseController
{

    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;
    protected $dokterModel;
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
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

    public function Antrian()
    {

        $session = session();
        if ($session->get('role') != 'admin') {
            return redirect()->to('/login')->with('error', 'Silahkan login sebagai admin.');
        };

        $pasinTerdaftar = $this->jadwalModel->getAllPasienTerdaftar();


        return view('/admin/antrian', [
            'pasienTerdaftar' => $pasinTerdaftar
        ]);
    }

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

    public function tambahPasien()
    {
        return view('admin/tambahpasien', [
            'title' => 'Tambah Pasien'
        ]);
    }

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

    public function editPasien($id)
    {
        $pasien = $this->pasienModel->find($id);
        return view('admin/editpasien', [
            'title' => 'Edit Pasien',
            'pasien' => $pasien
        ]);
    }

    public function updatePasien($id)
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

        $this->pasienModel->update($id, $data);
        return redirect()->to('/admin/kelolapasien')->with('success', 'Data pasien berhasil diubah.');
    }

    public function hapusPasien($id)
    {
        $this->pasienModel->delete($id);
        return redirect()->to('/admin/kelolapasien')->with('sucess', 'Data pasien berhasil dihapus.');
    }

    public function riwayatPemeriksaanPasien($id)
    {
        $riwayatPemeriksaanModel = new \App\Models\RiwayatModel();
        $riwayatPemeriksaan = $riwayatPemeriksaanModel->where('id_pasien', $id)->findAll();
        $pasien = $this->pasienModel->find($id);

        return view('admin/riwayatpemeriksaan', [
            'title' => 'Riwayat Pemeriksaan Pasien',
            'riwayatPemeriksaan' => $riwayatPemeriksaan,
            'pasien' => $pasien

        ]);
    }


    public function kelolaDokter()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $doker = $this->dokterModel
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

    public function tambahDokterr()
    {
        return view('admin/tambahdokter', [
            'title' => 'Tambah Dokter'
        ]);
    }

    public function simpanDokter()
    {
        $data = [

            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
        ];

        $this->dokterModel->insert($data);
        return redirect()->to('/admin/keloladokter')->with('success', 'Data pasien berhasi ditambahkan.');
    }

    public function editDokter($id)
    {
        $dokter = $this->dokterModel->find($id);
        return view('admin/editdokter', [
            'title' => 'Edit Dokter',
            'dokter' => $dokter
        ]);
    }

    public function updateDokter($id)
    {
        $data = [

            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),

        ];

        $this->dokterModel->update($id, $data);
        return redirect()->to('/admin/keloladokter')->with('success', 'Data pasien berhasil diubah.');
    }

    public function hapusDokter($id)
    {
        $this->dokterModel->delete($id);
        return redirect()->to('/admin/keloladokter')->with('sucess', 'Data pasien berhasil dihapus.');
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
}

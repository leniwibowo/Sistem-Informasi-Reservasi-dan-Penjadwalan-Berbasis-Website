<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\JadwalModel;
use App\Models\RiwayatModel;
use App\Models\PasienModel;

class Pasien extends BaseController
{
    // deklarasi
    protected $antrianModel;
    protected $jadwalModel;
    protected $riwayatModel;
    protected $pasienModel;

    // inisialisasi model
    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->jadwalModel = new JadwalModel();
        $this->riwayatModel = new RiwayatModel();
        $this->pasienModel = new PasienModel();
    }

    // untuk menampilkan halaman dashboard pasien
    public function index()
    {
        // tampilan dashboard mengambil id_user berdasarkan pasien yang login
        $id_user = session()->get('id_user');
        $pasienInfo = $this->pasienModel->where('id_user', $id_user)->first();
        if (!$pasienInfo) {

            return redirect()->to('/logout')->with('error', 'Data pasien tidak ditemukan.');
        }

        $id_pasien_benar = $pasienInfo['id_pasien'];

        // mengambil status antrian dari tabel antrian
        $status_antrian = $this->antrianModel->getStatusAntrianPasien($id_pasien_benar);

        // menampilkan gabungan tabel  dari jadwalModel
        $jadwal = $this->jadwalModel
            ->select('jadwal.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter', 'left')
            ->where('id_pasien', $id_pasien_benar)
            ->where('tanggal_pemeriksaan >=', date('Y-m-d'))
            ->orderBy('tanggal_pemeriksaan', 'ASC')
            ->first();
        // untuk menampilkan gabungan data riwayat pemeriksaan dari model 
        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter', 'left')
            ->where('riwayat_pemeriksaan.id_pasien', $id_pasien_benar) // 
            ->orderBy('waktu', 'DESC')
            ->limit(3)
            ->find();
        // data yang tampil dihalaman dashboard pasien
        $data = [
            'title'             => 'Dashboard Pasien',
            'pasien'            => $pasienInfo,
            'jadwal'            => $jadwal,
            'riwayat'           => $riwayat,
            'nomor_antrian_anda' => $status_antrian['nomor_antrian_anda'],
            'antrian_sekarang'  => $status_antrian['antrian_sekarang'],
            'sisa_antrian'      => $status_antrian['sisa_antrian'],
        ];

        return view('pasien/dashboard', $data);
    }

    // profil pasien
    public function profil()
    {
        //mengambil id_user berdasarkan pasien yang login dari pasienModel
        $userId = session()->get('id_user');
        $pasien = $this->pasienModel->where('id_user', $userId)->first();

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }
        // ke halaman view/porfil.php
        return view('pasien/profil', [
            'title' => 'Profil Pasien',
            'pasien' => $pasien
        ]);
    }


    // /
    // riwayat pemeriksaan pasien
    public function RiwayatPemeriksaan()
    {
        $id_user = session()->get('id_user'); // 

        // Cari id_pasien berdasarkan id_user
        $pasien = $this->pasienModel->where('id_user', $id_user)->first();
        $id_pasien = $pasien['id_pasien'] ?? null;

        if (!$id_pasien) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        // gabungan tampilan data dari tabel riwayat model 
        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_pasien', $id_pasien)
            ->orderBy('waktu', 'DESC')
            ->findAll();

        return view('pasien/riwayat_pemeriksaan', [
            'title' => 'Riwayat Pemeriksaan',
            'riwayat' => $riwayat
        ]);
    }
}
// edit pasien
    // public function edit($id)
    // {
    //     $pasien = $this->pasienModel->find($id);
    //     return view('pasien/edit_pasien', [
    //         'title' => 'Edit Pasien',
    //         'pasien' => $pasien
    //     ]);
    // }

    // // Method untuk memproses data yang di-submit dari form
    // public function update($id)
    // {
    //     $data = [
    //         'nama' => $this->request->getPost('nama'),
    //         'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
    //         'no_hp' => $this->request->getPost('no_hp'),
    //         'alamat' => $this->request->getPost('alamat'),
    //         'alergi' => $this->request->getPost('alergi'),
    //         'golongan_darah' => $this->request->getPost('golongan_darah'),
    //         'penyakit_jantung' => $this->request->getPost('penyakit_jantung'),
    //         'diabetes' => $this->request->getPost('diabetes'),
    //     ];

    //     // Optional: Jika username boleh diubah
    //     if ($this->request->getPost('username')) {
    //         $data['username'] = $this->request->getPost('username');
    //     }

    //     // Optional: Jika password boleh diubah
    //     if ($this->request->getPost('password')) {
    //         $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    //     }

    //     $this->pasienModel->update($id, $data);
    //     return redirect()->to('/pasien/edit')->with('success', 'Data pasien berhasil diubah.');
    
    // }
//   <a href="<?= base_url('pasien/edit/' . $pasien['id_pasien'])"class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profil</a>  //class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profil</a> 
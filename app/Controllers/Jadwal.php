<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\JadwalModel;
use App\Models\AntrianModel;
use CodeIgniter\HTTP\ResponseInterface;


class Jadwal extends BaseController
{

    protected $pasienModel;
    protected $jadwalModel;
    protected $antrianModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
    }

    public function simpan()
    {

        $session = session();
        $id_user = $session->get('id_user');




        $pasien = $this->pasienModel->where('id_user', $id_user)->first();
        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        $keluhan = $this->request->getPost('keluhan');
        $tanggal = $this->request->getPost('tanggal');

        // Cari jadwal dokter sesuai hari
        $hari = date('l', strtotime($tanggal));
        $db = \Config\Database::connect();
        $dokter = $db->table('jadwal_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hari)
            ->get()
            ->getRowArray();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Tidak ada dokter yang bertugas pada hari tersebut.');
        }

        // Simpan ke tabel jadwal
        $this->jadwalModel->insert([
            'id_dokter' => $dokter['id_dokter'],
            'id_pasien' => $pasien['id_pasien'],
            'tanggal_pemeriksaan' => $tanggal,
            'keluhan' => $keluhan,
            'status' => 'Menunggu',
        ]);
        $id_jadwal = $this->jadwalModel->getInsertID();

        // Hitung no antrian
        $jumlah_antrian = $this->antrianModel->where('id_jadwal', $id_jadwal)->countAllResults();
        $no_antrian = $jumlah_antrian + 1;
        return redirect()->to('/jadwal')->with('success', 'Berhasil mendaftar!');
    }
    public function index()
    {
        // mengambil id user yang sedang login dari session
        $session = session();
        $userId = session()->get('id_user');

        $pasienModel = new PasienModel();
        $pasien = $this->pasienModel->where('id_user', $userId)->first(); //mencari data pasien berdafarkan id

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan'); // jika data pasien tidak ditemukan arahke ke dashboard
        }

        $antrian = $this->antrianModel
            ->select('antrian.*, jadwal.tanggal_pemeriksaan as tanggal, dokter.nama as nama_dokter')
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            // ->join('riwayat_pemeriksaan', 'riwayat_pemeriksaan.id_pasien = antrian.id_pasien AND riwayat_pemeriksaan.id_dokter = jadwal.id_dokter', 'left')
            ->where('antrian.id_pasien', $pasien['id_pasien'])
            ->where('antrian.status', 'Menunggu')
            ->orderBy('jadwal.tanggal_pemeriksaan', 'ASC')
            ->first(); //ambil data paling baru

        $data = [
            'title' => 'jadwal',
            'antrian' => $antrian,
            'pasien' => $pasien,
            'jadwal_pasien' => $antrian

        ];

        return view('jadwal', [
            'jadwal_pasien' => $antrian,

        ]);
    }
}

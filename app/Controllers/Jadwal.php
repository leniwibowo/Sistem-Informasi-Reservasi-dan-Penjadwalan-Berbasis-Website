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
        $userId = $session->get('id_user');
        $id_user = $session->get('id_user');

        $pasien = $this->pasienModel->where('id_user', $userId)->first();

        $pasien = $this->pasienModel->where('id_user', $id_user)->first();
        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan');
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        $keluhan = $this->request->getPost('keluhan');
        $tanggal = $this->request->getPost('tanggal');

        // menentukan hari dari tanggal 
        // Cari jadwal dokter sesuai hari
        $hari = date('l', strtotime($tanggal));

        // mencari dokter sesuai hari dari tabel jadwal_dokter
        $db = \Config\Database::connect();
        $dokter = $db->table('jadwal_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->get()
            ->getRowArray();

        if (!$dokter) {
            return redirect()->to('/jadwal')->with('error', 'Tidak ada dokter yang bertugas hari itu');
            return redirect()->back()->with('error', 'Tidak ada dokter yang bertugas pada hari tersebut.');
        }

        // simpan ke tabel jadwal 
        // Simpan ke tabel jadwal
        $this->jadwalModel->insert([
            'id_dokter' => $dokter['id_dokter'],
            'id_pasien' => $pasien['id_pasien'],
            'tanggal_pemeriksaan' => $tanggal,
            'status' => 'Menunggu',
            'status' => 'Menunggu',
        ]);
        $id_jadwal = $this->jadwalModel->getInsertID();

        // menghitung nomor antrian
        $nomor = $this->antrianModel
            ->where('id_jadwal', $id_jadwal)
            ->countAllResults() + 1;

        // simpan ke tabel antrian
        $data = [
            'id_jadwal' => $id_jadwal,
            'id_pasien' => $pasien['id_pasien'],
            'no_antrian' =>  $nomor,
            'keluhan' => $keluhan,
            'status' => 'Menunggu',
            'tanggal' => $tanggal
        ];

        if (!$this->antrianModel->insert($data)) {
            dd('Gagal insert', $data, $this->antrianModel->errors());
        }

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

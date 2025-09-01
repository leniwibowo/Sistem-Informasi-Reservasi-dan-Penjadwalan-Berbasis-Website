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


    // penerapan metode fcfs
    public function simpan()
    {

        // mengambil id_user berdasarkan pasien yang login
        $session = session();
        $id_user = $session->get('id_user');

        // Ambil data pasien berdasarkan id_user yang login
        $pasien = $this->pasienModel->where('id_user', $id_user)->first();
        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan');
        }
        // data keluhan dan tanggal
        $keluhan = $this->request->getPost('keluhan');
        $tanggal = $this->request->getPost('tanggal');
        $hari = date('l', strtotime($tanggal)); // contoh: Monday, Tuesday, dll

        // Cari dokter yang sesuai dengan hari dipilih
        $db = \Config\Database::connect();
        $dokter = $db->table('jadwal_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hari)
            ->get()
            ->getRowArray();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Tidak ada dokter yang bertugas pada hari tersebut.');
        }

        // simpan ke tabel jadwal
        $this->jadwalModel->insert([
            'id_dokter' => $dokter['id_dokter'],
            'id_pasien' => $pasien['id_pasien'],
            'tanggal_pemeriksaan' => $tanggal,
            'status' => 'Menunggu',
            'pemeriksaan' => '' //
        ]);
        $id_jadwal = $this->jadwalModel->getInsertID();

        // hitung nomor antrian berdasarkan tanggal & dokter
        $jumlah_antrian = $this->antrianModel
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->where('jadwal.tanggal_pemeriksaan', $tanggal)
            ->where('jadwal.id_dokter', $dokter['id_dokter'])
            ->countAllResults();

        $no_antrian = $jumlah_antrian + 1; //fcfs

        // simpan ke tabel antrian
        $this->antrianModel->insert([
            'id_jadwal' => $id_jadwal,
            'id_pasien' => $pasien['id_pasien'],
            'no_antrian' => $no_antrian,
            'keluhan' => $keluhan,
            'status' => 'Menunggu',
            'tanggal' => $tanggal
        ]);

        return redirect()->to('/jadwal')->with('success', 'Berhasil mendaftar!');
    }


    //untuk tampilan jadwal 
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
        //menampilkan gabungan tabel
        $jadwal_pasien = $this->antrianModel
            ->select('antrian.*, jadwal.tanggal_pemeriksaan as tanggal, dokter.nama as nama_dokter')
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->where('antrian.id_pasien', $pasien['id_pasien'])
            ->orderBy('jadwal.tanggal_pemeriksaan', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Jadwal Saya',
            'jadwal_pasien' => $jadwal_pasien,
        ];

        return view('pasien/jadwal', $data);
    }
}

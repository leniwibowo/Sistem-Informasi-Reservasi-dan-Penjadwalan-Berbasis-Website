<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\JadwalModel;
use App\Models\PasienModel;

class Antrian extends BaseController
{
    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->jadwalModel = new JadwalModel();
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        // mengambil id_user berdasarkan pasien yang login
        $session = session();
        $userId = $session->get('id_user');

        $pasien = $this->pasienModel->where('id_user', $userId)->first();
        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }
        // menampilkan data di pendaftaran antrian pasien 
        $data = [
            'pasien' => $pasien,
            'title' => 'Pendaftaran Antrian Pasien'
        ];
        return view('pasien/pendaftaran', $data);
    }

    // menyimpan antrian untuk pasien yang telah melakukan pendaftaran

    public function simpan()
    {
        // mengambil id_user berdasarkan pasien yang login
        $session = session();
        $userId = $session->get('id_user');
        $pasien = $this->pasienModel->where('id_user', $userId)->first();

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        // untuk menginputkan keluhan pasien
        $keluhan = $this->request->getPost('keluhan');
        $tanggal = $this->request->getPost('tanggal');

        //  cekan pendaftaran ganda 
        // Pengecekan ini harusnya ke tabel jadwal, bukan antrian 
        $jadwalSudahAda = $this->jadwalModel
            ->where('id_pasien', $pasien['id_pasien'])
            ->where('tanggal_pemeriksaan', $tanggal)
            ->where('status', 'Menunggu')
            ->first();
        // jika masih memliki pendaftaran
        if ($jadwalSudahAda) {
            // ---  arahkan kembali ke halaman form (/antrian) ---
            return redirect()->to('/antrian')->with('error', 'Anda sudah memiliki jadwal di tanggal ini yang masih menunggu.');
        }

        // --- logika Pencarian Hari ---
        // menggunakan array untuk mapping nama hari dari Inggris ke Indonesia
        $hari = date('l', strtotime($tanggal)); // lngsung gunakan 'Tuesday'

        $db = \Config\Database::connect();
        $dokter = $db->table('jadwal_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hari) // sekarang mencari 'Tuesday', cocok dengan DB
            ->get()
            ->getRowArray();

        // jika tidak ada dokter yang bertugas saat memilih hari tidak bisa
        if (!$dokter) {
            return redirect()->to('/antrian')->with('error', 'Tidak ada dokter yang bertugas pada hari tersebut.');
        }

        //  menyimpanan ke tabel jadwal 
        $this->jadwalModel->save([
            'id_pasien'           => $pasien['id_pasien'],
            'id_dokter'           => $dokter['id_dokter'],
            'tanggal_pemeriksaan' => $tanggal,
            'status'              => 'Menunggu',
        ]);
        $id_jadwal = $this->jadwalModel->getInsertID();

        // ---  logika nomor antrian  ---
        //hitung antrian berdasarkan dokter dan tanggal/ 
        $jumlahAntrianSebelumnya = $this->antrianModel
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->where('jadwal.id_dokter', $dokter['id_dokter'])
            ->where('jadwal.tanggal_pemeriksaan', $tanggal)
            ->countAllResults();

        $nomor_antrian = $jumlahAntrianSebelumnya + 1;

        // mengambil data dari tabel antrian model
        $dataAntrian = [
            'id_pasien' => $pasien['id_pasien'],
            'id_jadwal' => $id_jadwal,
            'tanggal' => $tanggal,
            'no_antrian' => $nomor_antrian,
            'no_RM' => $pasien['no_RM'],
            'status' => 'Menunggu',
            'urutan_panggil' => $nomor_antrian,
            'keluhan' => $keluhan
        ];

        if (!$this->antrianModel->save($dataAntrian)) {
            // jika ada error dari model, tampilkan untuk debugging
            return redirect()->to('/antrian')->with('error', implode('<br>', $this->antrianModel->errors()));
        }

        return redirect()->to('/jadwal')->with('success', 'Pendaftaran berhasil! Nomor antrian Anda adalah ' . $nomor_antrian);
    }
}

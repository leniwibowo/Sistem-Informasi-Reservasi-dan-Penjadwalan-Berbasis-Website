<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\JadwalModel;
use App\Models\AntrianModel;

class Antrian extends BaseController
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

    public function index()
    {
        // dd(session()->get());
        $userId = session()->get('id_user'); //mengambil id user yang sedang login dari session

        $pasien = $this->pasienModel->where('id_user', $userId)->first(); //mengambil data pasien berdasarkan id_user

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.'); // untuk menampilkan pesan jika pasien tidak ditemukan
        }

        $today = date('Y-m-d');
        $twoDaysLater = date('Y-m-d', strtotime('+2 days'));

        $jadwal = $this->jadwalModel
            ->select(('jadwal.*, dokter.nama as nama_dokter'))
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter') // mengambil jadwal dokter untuk 2 hari kedepan
            ->where('tanggal_pemeriksaan >=', $today)
            ->where('tanggal_pemeriksaan <=', $twoDaysLater)
            ->findAll();

        // mengirim data ke view

        $data = [
            'title' => 'pendaftaran',
            'pasien' => $pasien,
            'jadwal' => $jadwal
        ];

        return view('pendaftaran', $data);
    }

    public function simpan()
    {
        $request = $this->request;

        $id_pasien = $request->getPost('id_pasien');
        $jadwal_id = $request->getPost('id_jadwal');
        $tanggal = $request->getPost('tanggal');
        $no_RM =  $request->getPost('no_RM');
        $keluhan = $request->getPost('keluhan');

        // Validasi sederhana
        if (!$id_pasien || !$jadwal_id || !$tanggal) {
            return redirect()->back()->with('error', 'Data tidak lengkap.');
        }

        // menghitung jumlah antrian yang sudah ada untuk jadwal yang dipilih
        $jumlah_antrian = $this->antrianModel
            ->where('id_jadwal', $jadwal_id)
            ->countAllResults();

        $nomor_antrian = $jumlah_antrian + 1;

        // siapkan data insert
        $data = [
            'id_pasien' => $id_pasien,
            'id_jadwal' => $jadwal_id,
            'tanggal' => $tanggal,
            'no_RM' => $no_RM,
            'no_antrian' => $nomor_antrian,
            'status' => 'Menunggu',
            'keluhan' => $keluhan
        ];

        if (!$this->antrianModel->save($data)) {
            return redirect()->back()->with('error', 'Gagal mendaftar.')->withInput();
        }
        dd($data);

        return redirect()->to('/jadwal')->with('success', 'Pendaftaran berhasil');
    }
}

<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\RiwayatModel;


class Pasien extends BaseController
{
    protected $pasienModel;
    protected $riwayatModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->riwayatModel = new RiwayatModel();
    }
    public function index()
    {
        // ambil data user dari session
        $pasien = session()->get('pasien');

        return view('dashboard', [
            'pasien' => $pasien
        ]);
    }

    public function profil()
    {
        $userId = session()->get('id_user');
        $pasien = $this->pasienModel->where('id_user', $userId)->first();

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        return view('pasien/profil', [
            'title' => 'Profil Pasien',
            'pasien' => $pasien
        ]);
    }

    public function RiwayatPemeriksaan()
    {


        $id_user = session()->get('id_user'); // Ambil ID pasien yang sedang login

        // Cari id_pasien berdasarkan id_user
        $pasien = $this->pasienModel->where('id_user', $id_user)->first();
        $id_pasien = $pasien['id_pasien'] ?? null;

        if (!$id_pasien) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }


        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_pasien', $id_pasien)
            ->orderBy('waktu', 'DESC')
            ->findAll();

        return view('riwayat_pemeriksaan', [
            'title' => 'Riwayat Pemeriksaan',
            'riwayat' => $riwayat
        ]);
    }
}

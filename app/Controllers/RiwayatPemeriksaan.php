<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RiwayatModel;
use CodeIgniter\HTTP\ResponseInterface;

class RiwayatPemeriksaan extends BaseController
{
    protected $riwayatModel;

    public function __construct()
    {
        $this->riwayatModel = new RiwayatModel();
    }

    // riwayat pemeriksaan pasien
    public function index()
    {
        $userID = session()->get('id_pasien');

        $riwayat = $this->riwayatModel
            ->select('riwayat_pemeriksaan.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
            ->join('pasien', 'pasien.id_pasien = riwayat_pemeriksaan.id_pasien')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_pasien', $userID)
            ->orderBy('waktu', 'DESC')
            ->findAll();
        return view('riwayat_pemeriksaan', [
            'riwayat' => $riwayat
        ]);
    }
}

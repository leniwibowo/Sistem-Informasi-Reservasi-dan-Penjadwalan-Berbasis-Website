<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $jadwalModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {

        if (!session()->get('isLoggedIn') || session()->get('role') !== 'pasien') {
            return redirect()->to('/auth')->with('error', 'Silakan login sebagai pasien untuk mengakses dashboard.');
        }

        $userID = session()->get('id_user');

        $antrian = $this->jadwalModel
            ->where('tanggal_pemeriksaan', date('Y-m-d'))
            ->countAllResults();

        // mengambil total antrian (misal: pasien yang belum hadir)
        $sisa_antrian = $this->jadwalModel
            ->where('tanggal_pemeriksaan', date('Y-m-d'))
            ->where('status', 'belum_hadir')
            ->countAllResults();

        // ambil jadwal pasien login hari ini atau berikutnya
        $jadwal = $this->jadwalModel
            ->select('jadwal.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->where('id_pasien', $userID)
            ->where('tanggal_pemeriksaan >=', date('Y-m-d'))
            ->orderBy('tanggal_pemeriksaan', 'ASC')
            ->first();

        if (!$jadwal) {
            $jadwal = [
                'tanggal_pemeriksaan' => 'null',
                'nama_dokter' => '-',
                'status' => '-',
                'pemeriksaan' => '-',
                'nomor_antrian' => '-',
                'tindakan' => '_'

            ];
        }

        return view('pasien/dashboard', [
            'antrian' => $antrian,
            'sisa_antrian' => $sisa_antrian,
            'jadwal' => $jadwal

        ]);
    }
}

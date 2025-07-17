<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JadwalModel;

class Dokter extends BaseController
{
    protected $jadwalModel;
    public function antrian()
    {

        // if (!session()->get('id_user') || session()->get('role') != 'dokter') {
        //     return redirect()->to('/login');
        // }

        // ambil antrtian hari dan urutan berdasarkan nomor antrian
        $data['antrian'] = $this->jadwalModel
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->join('antrian', 'antrian.id_pasien = jadwal.id_pasien AND antrian.tanggal = jadwal.tanggal_pemeriksaan')
            ->where('jadwal.tanggal_pemeriksaan', date('Y-m-d'))
            ->orderBy('antrian.id_antrian', 'ASC')
            ->findAll();
        return view('/dokter/antrian');
    }

    public function datapasien()
    {

        // if (!session()->get('id_user') || session()->get('role') != 'dokter') {
        //     return redirect()->to('/login');
        // }

        // ambil antrtian hari dan urutan berdasarkan nomor antrian

        return view('/dokter/datapasien');
    }
    public function pasienterjadwal()
    {

        // if (!session()->get('id_user') || session()->get('role') != 'dokter') {
        //     return redirect()->to('/login');
        // }

        // ambil antrtian hari dan urutan berdasarkan nomor antrian

        return view('/dokter/pasienterjadwal');
    }

    public function priksa($id_jadwal)
    {
        $jadwalModel = new \App\Models\JadwalModel();
        $pasienModel = new \App\Models\PasienModel();

        // mengambil data jadwal berdasarkan id_jadwal
        $jadwal = $jadwalModel->find($id_jadwal);

        if (!$jadwal) {
            return redirect()->to('/dokter/antrian')->with('error', 'Data jadwal tidak ditemukan');
        }

        // ambil data pasien terkait
        $jadwal = $this->jadwalModel->find($id_jadwal);
        $pasien = $pasienModel->find($jadwal['id_pasien']);

        $data = [
            'title' => 'Pemeriksaan Pasien',
            'jadwal' => $jadwal,
            'pasien' => $pasien,
        ];

        return view('dokter/pemeriksaan', $data);
    }

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
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

        // ambil jadwal pasien login hari ini atau berikutnya
        // $jadwal = $this->jadwalModel
        // ->where('id_pasien', $userID)
        // ->where('tanggal_pemeriksaan >=', date('Y-m-d'))
        // ->orderBy('tanggal_pemeriksaan', 'ASC')
        // ->first();

        return view('dokter/dashboard', [
            'antrian' => $antrian,
            'sisa_antrian' => $sisa_antrian,
            // 'jadwal' => $jadwal

        ]);
    }
}

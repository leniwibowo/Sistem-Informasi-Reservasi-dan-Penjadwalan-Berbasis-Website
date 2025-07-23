<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JadwalModel;
use App\Models\PasienModel;
use App\Models\AntrianModel;

class Dokter extends BaseController
{

    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
        $this->pasienModel = new PasienModel();
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

        return view('dokter/dashboard', [
            'antrian' => $antrian,
            'sisa_antrian' => $sisa_antrian,
            // 'jadwal' => $jadwal

        ]);
    }

    // antrian
    public function antrian()
    {

        $antrian = $this->antrianModel
            ->select('antrian.*, jadwal.tanggal_pemeriksaan, dokter.nama as nama_dokter, pasien.nama as nama_pasien')
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->join('pasien', 'pasien.id_pasien = antrian.id_pasien')
            ->where('jadwal.tanggal_pemeriksaan', date('Y-m-d'))
            ->orderBy('antrian.no_antrian', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Antrian Pasien',
            'antrian' => $antrian ?? []
        ];
        return view('/dokter/antrian', [
            'antrian' => $antrian
        ]);
    }
    // datapasien
    public function datapasien()
    {
        $session = session();
        if ($session->get('role') != 'dokter') {
            return redirect()->to('/login')->with('error', 'Silahkan login sebagai dokter.');
        };

        // mengambi pasien yang sudah pernah melakukan pemeriksaan
        $data = [
            'title' => 'Daftar Pasien',
            'pasien' => $this->pasienModel->getPasienPernahDaftar(),
        ];


        return view('/dokter/datapasien', $data);
    }
    // pasien terjadwal
    public function pasienterjadwal()
    {
        $session = session();

        if ($session->get('role') != 'dokter') {
            return redirect()->to('/login')->with('error', 'Silahkan login sebagai dokter');
        }

        $id_dokter = $session->get('id_dokter');


        $data = [
            'title' => 'Pasien Terjadwal',
            'jadwal' => $this->jadwalModel->getPasienTerjadwalByDokter($id_dokter),
        ];

        // ambil antrtian hari dan urutan berdasarkan nomor antrian

        return view('/dokter/pasienterjadwal', $data);
    }

    // logika pemeriksaan

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
        $jadwal = $this->jadwalModel->where('id_jadwal', $id_jadwal)->first();
        $pasien = $this->pasienModel->where('id_pasien', $jadwal['id_pasien'])->first();

        $data = [
            'title' => 'Pemeriksaan Pasien',
            'jadwal' => $jadwal,
            'pasien' => $pasien,
        ];

        return view('dokter/pemeriksaan', $data);
    }
}

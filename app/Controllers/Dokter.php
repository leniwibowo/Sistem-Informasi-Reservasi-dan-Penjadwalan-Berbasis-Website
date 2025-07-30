<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JadwalModel;
use App\Models\PasienModel;
use App\Models\AntrianModel;
use App\Models\RiwayatModel;

class Dokter extends BaseController
{

    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;
    protected $riwayatModel;
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
        $this->pasienModel = new PasienModel();
        $this->riwayatModel = new RiwayatModel();
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
            ->select('antrian.*, jadwal.tanggal_pemeriksaan, jadwal.status, dokter.nama as nama_dokter, pasien.nama as nama_pasien')
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

    public function Pemeriksaan($id_jadwal)
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

    public function simpanPemeriksaan($id_jadwal)
    {
        $jadwal = $this->jadwalModel->find($id_jadwal);
        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        $diagnosis = $this->request->getPost('diagnosis');
        $keluhan = $this->request->getPost('keluhan');
        $resep = $this->request->getPost('resep');

        // Simpan ke tabel riwayat_pemeriksaan
        $this->riwayatModel->insert([
            'id_pasien' => $jadwal['id_pasien'],
            'id_dokter' => $jadwal['id_dokter'],
            'waktu' => date('Y-m-d H:i:s'),
            'diagnosis' => $diagnosis,
            'keluhan' => $keluhan,
            'resep' => $resep,
        ]);

        // Update status di tabel jadwal (misal: dari 'Menunggu' jadi 'Selesai')
        $this->jadwalModel->update($id_jadwal, ['status' => 'Selesai']);

        return redirect()->to('/dokter/antrian')->with('success', 'Pemeriksaan berhasil disimpan.');
    }

    public function riwayatPemeriksaanPasien($id_pasien)
    {
        $riwayatModel = new RiwayatModel();
        $pasienModel = new PasienModel();

        $riwayat = $riwayatModel->getRiwayatByPasien($id_pasien);
        $pasien = $pasienModel->find($id_pasien);

        return view('dokter/riwayatpemeriksaan', [
            'title' => 'Riwayat Pemeriksaan',
            'riwayat' => $riwayat,
            'pasien' => $pasien
        ]);
    }
}

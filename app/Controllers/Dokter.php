<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\PasienModel;
use App\Models\AntrianModel;
use App\Models\RiwayatModel;
use App\Models\DokterModel;

class Dokter extends BaseController
{
    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;
    protected $riwayatModel;
    protected $dokterModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->antrianModel = new AntrianModel();
        $this->pasienModel = new PasienModel();
        $this->riwayatModel = new RiwayatModel();
        $this->dokterModel = new DokterModel();
    }

    // menampilkan halaman dashboard
    public function index()
    {
        // ambil ID dokter dari sesi login
        $id_dokter = session()->get('id_dokter');

        // 
        // megambil data lengkap dokter dari database menggunakan ID dari sesi.
        $dokter_info = $this->dokterModel->find($id_dokter);

        // jika data dokter ditemukan, ambil namanya. Jika tidak, beri nama default.
        $nama_dokter = $dokter_info ? $dokter_info['nama'] : 'Tanpa Nama';

        // untuk memapilkan total antrian dihalaman dokter
        $total_antrian = $this->antrianModel
            ->where('tanggal', date('Y-m-d'))
            ->countAllResults();
        // untuk menapilkan total sisa antrian halaman okter
        $sisa_antrian = $this->antrianModel
            ->where('tanggal', date('Y-m-d'))
            ->where('status', 'Menunggu')
            ->countAllResults();

        $pasien_terjadwal_count = $this->jadwalModel
            ->countPasienTerjadwalHariIni($id_dokter);

        // untuk tabel dan daftar ambil dari antrianModel dan jadwalModel
        $antrian_berikutnya = $this->antrianModel->getAntrianBerikutnya(5);
        $jadwal_janji_temu = $this->jadwalModel->getJadwalJanjiTemuHariIni($id_dokter, 5);
        // menampilkan data di dahboard
        $data = [
            'title'                     => 'Dashboard Dokter',
            'nama_dokter'               => $nama_dokter, // 
            'total_antrian'             => $total_antrian,
            'sisa_antrian'              => $sisa_antrian,
            'pasien_terjadwal_count'    => $pasien_terjadwal_count,
            'antrian_berikutnya'        => $antrian_berikutnya,
            'jadwal_janji_temu'         => $jadwal_janji_temu,
        ];

        return view('dokter/dashboard', $data);
    }

    // antrian
    public function antrian()
    {
        // ambil dari antrian model 
        $antrian = $this->antrianModel
            ->select('antrian.*, jadwal.tanggal_pemeriksaan, antrian.status, dokter.nama as nama_dokter, pasien.nama as nama_pasien')
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


    // pemeriksaan pasien
    public function Pemeriksaan($id_jadwal)
    {
        $jadwalModel = new \App\Models\JadwalModel();
        $pasienModel = new \App\Models\PasienModel();
        $antrianModel = new \App\Models\AntrianModel();

        // mengambil data jadwal berdasarkan id_jadwal dari jadwal model
        $jadwal = $jadwalModel->find($id_jadwal);

        if (!$jadwal) {
            return redirect()->to('/dokter/antrian')->with('error', 'Data jadwal tidak ditemukan');
        }

        // ambil antrian yang terkait dengan jadwal ini untuk mendapatkan keluhan dari antrianModel
        $antrian = $antrianModel->where('id_jadwal', $id_jadwal)->first();
        // jika tidak ada antrian, berikan nilai default
        $jadwal['keluhan'] = $antrian['keluhan'] ?? 'Tidak ada keluhan tercatat';


        // ambil data pasien terkait
        $pasien = $pasienModel->find($jadwal['id_pasien']);

        if (!$pasien) {
            return redirect()->to('/dokter/antrian')->with('error', 'Data pasien tidak ditemukan');
        }

        // $jadwal sudah berisi 'keluhan'
        $data = [
            'title' => 'Pemeriksaan Pasien',
            'jadwal' => $jadwal,
            'pasien' => $pasien,
        ];

        return view('dokter/pemeriksaan', $data);
    }


    // menyimpan pemeriksaan yang telah dilakukan oleh dokter
    public function simpanPemeriksaan($id_jadwal)
    {
        $jadwal = $this->jadwalModel->find($id_jadwal);
        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        // ambil data dari form yang disubmit
        $diagnosis = $this->request->getPost('diagnosis');
        $tindakan  = $this->request->getPost('tindakan');
        $resep     = $this->request->getPost('resep');
        $keluhan   = $this->request->getPost('keluhan');
        $catatan   = $this->request->getPost('catatan');

        // simpan ke tabel riwayat_pemeriksaan
        $this->riwayatModel->insert([
            'id_pasien' => $jadwal['id_pasien'],
            'id_dokter' => $jadwal['id_dokter'],
            'waktu'     => date('Y-m-d H:i:s'),
            'diagnosis' => $diagnosis,
            'tindakan'  => $tindakan,
            'keluhan'   => $keluhan,
            'catatan'   => $catatan,
            'resep'     => $resep,
        ]);

        // update status di tabel jadwal ('Menunggu' jadi 'Selesai')
        $this->jadwalModel->update($id_jadwal, ['status' => 'Selesai']);

        return redirect()->to('/dokter/antrian')->with('success', 'Pemeriksaan berhasil disimpan.');
    }

    // datapasien
    public function datapasien()
    {
        $session = session();
        if ($session->get('role') != 'dokter') {
            return redirect()->to('/login')->with('error', 'Silahkan login sebagai dokter.');
        };

        // mengambi pasien yang sudah pernah melakukan pemeriksaan dari pasienModel
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

        // mengambil ID dokter dari sesi
        $id_dokter = $session->get('id_dokter');

        // mmanggil fungsi model yang sudah diperbaiki
        $jadwal = $this->jadwalModel->getPasienTerjadwalByDokter($id_dokter);

        $data = [
            'title' => 'Pasien Terjadwal',
            'jadwal' => $jadwal,
        ];

        // menggunakan view yang benar untuk dokter
        return view('dokter/pasienterjadwal', $data);
    }


    // logika pemeriksaan

    public function riwayatPemeriksaanPasien($id_pasien)
    {
        $riwayatModel = new RiwayatModel();
        $pasienModel = new PasienModel();

        // ambil dari riwayatModel
        $riwayat = $riwayatModel->getRiwayatByPasien($id_pasien);
        $pasien = $pasienModel->find($id_pasien);

        return view('dokter/riwayatpemeriksaan', [
            'title' => 'Riwayat Pemeriksaan',
            'riwayat' => $riwayat,
            'pasien' => $pasien
        ]);
    }

    // melihat profil dokter
    public function profil()
    {
        if (session()->get('role') !== 'dokter') {
            return redirect()->to('/login');
        }


        $id_user = session()->get('id_user');
        $data['dokter'] = $this->dokterModel->getDokterByUserId($id_user);

        return view('dokter/profile', $data);
    }
}

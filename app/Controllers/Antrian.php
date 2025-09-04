<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\JadwalModel;
use App\Models\PasienModel;
use App\Models\JadwalDokterModel;

class Antrian extends BaseController
{
    protected $antrianModel;
    protected $jadwalModel;
    protected $pasienModel;
    protected $jadwalDokterModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
        $this->jadwalModel = new JadwalModel();
        $this->pasienModel = new PasienModel();
        $this->jadwalDokterModel = new JadwalDokterModel();
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

    // UPDATED CODE: Fungsi untuk mengambil data dokter berdasarkan hari dan shift
    public function getDokter()
    {
        $tanggal = $this->request->getVar('tanggal');
        $shift   = $this->request->getVar('shift');

        log_message('debug', 'Fetching doctors for: Tanggal=' . $tanggal . ', Shift=' . $shift);

        // Pastikan input tanggal dan shift tidak kosong
        if (!$tanggal || !$shift) {
            log_message('error', 'Input tanggal atau shift kosong.');
            return $this->response->setJSON([]);
        }

        // Dapatkan nama hari dalam bahasa Inggris dari tanggal yang dipilih
        // Pastikan nama hari sesuai dengan data di database (misal: 'Wednesday')
        $hari_terpilih = date('l', strtotime($tanggal));

        // Ambil data dokter dari model JadwalDokterModel
        // Join dengan tabel dokter untuk mendapatkan nama dokter
        $dokter_tersedia = $this->jadwalDokterModel->select('jadwal_dokter.id_dokter, dokter.nama')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hari_terpilih)
            ->where('jadwal_dokter.shift', $shift)
            ->orderBy('dokter.nama', 'ASC')
            ->findAll();

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($dokter_tersedia);
    }



    // Fungsi untuk memproses pendaftaran antrian
    public function simpan()
    {
        $session = session();
        $userId = $session->get('id_user');
        $pasien = $this->pasienModel->where('id_user', $userId)->first();

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        $keluhan = $this->request->getPost('keluhan');
        $tanggal = $this->request->getPost('tanggal');
        $shift   = $this->request->getPost('shift');
        $id_dokter = $this->request->getPost('dokter');

        // Cek pendaftaran ganda
        $jadwalSudahAda = $this->jadwalModel
            ->where('id_pasien', $pasien['id_pasien'])
            ->where('tanggal_pemeriksaan', $tanggal)
            ->where('shift', $shift)
            ->where('status', 'Menunggu')
            ->first();

        if ($jadwalSudahAda) {
            return redirect()->to('/antrian')->with('error', 'Anda sudah memiliki jadwal di tanggal & shift ini yang masih menunggu.');
        }

        // Simpan ke tabel jadwal
        $this->jadwalModel->save([
            'id_pasien'             => $pasien['id_pasien'],
            'id_dokter'             => $id_dokter,
            'tanggal_pemeriksaan'   => $tanggal,
            'shift'                 => $shift,
            'status'                => 'Menunggu',
        ]);
        $id_jadwal = $this->jadwalModel->getInsertID();

        // Logika nomor antrian
        $jumlahAntrianSebelumnya = $this->antrianModel
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal')
            ->where('jadwal.id_dokter', $id_dokter)
            ->where('jadwal.tanggal_pemeriksaan', $tanggal)
            ->where('jadwal.shift', $shift)
            ->countAllResults();

        $nomor_antrian = $jumlahAntrianSebelumnya + 1;

        $dataAntrian = [
            'id_pasien'      => $pasien['id_pasien'],
            'id_jadwal'      => $id_jadwal,
            'tanggal'        => $tanggal,
            'no_antrian'     => $nomor_antrian,
            'no_RM'          => $pasien['no_RM'],
            'status'         => 'Menunggu',
            'urutan_panggil' => $nomor_antrian,
            'keluhan'        => $keluhan
        ];

        if (!$this->antrianModel->save($dataAntrian)) {
            return redirect()->to('/antrian')->with('error', implode('<br>', $this->antrianModel->errors()));
        }

        return redirect()->to('/jadwal')->with('success', 'Pendaftaran berhasil! Nomor antrian Anda adalah ' . $nomor_antrian);
    }
}

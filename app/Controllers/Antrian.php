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
        $session = session();
        $userId = $session->get('id_user');

        $pasien = $this->pasienModel->where('id_user', $userId)->first();
        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        $data = [
            'pasien' => $pasien,
            'title' => 'Pendaftaran Antrian Pasien'
        ];
        return view('pendaftaran', $data);
    }

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
        $hari = date('l', strtotime($tanggal));

        $db = \Config\Database::connect();
        $dokter = $db->table('jadwal_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hari)
            ->get()
            ->getRowArray();

        if (!$dokter) {
            return redirect()->to('/antrian')->with('error', 'Tidak ada dokter bertugas di hari tersebut.');
        }

        // Cek jika jadwal sudah ada
        $jadwal = $this->jadwalModel
            ->where('id_dokter', $dokter['id_dokter'])
            ->where('tanggal_pemeriksaan', $tanggal)
            ->first();

        if (!$jadwal) {
            $this->jadwalModel->save([
                'id_dokter' => $dokter['id_dokter'],
                'tanggal_pemeriksaan' => $tanggal,
                'status' => 'Menunggu'
            ]);
            $id_jadwal = $this->jadwalModel->getInsertID();
        } else {
            $id_jadwal = $jadwal['id_jadwal'];
        }

        // Hitung no antrian
        $nomor_antrian = $this->antrianModel
            ->where('id_jadwal', $id_jadwal)
            ->countAllResults() + 1;

        $data = [
            'id_pasien' => $pasien['id_pasien'],
            'id_jadwal' => $id_jadwal,
            'tanggal' => $tanggal,
            'no_antrian' => $nomor_antrian,
            'no_RM' => $pasien['no_RM'],
            'status' => 'Menunggu',
            'keluhan' => $keluhan
        ];

        if (!$this->antrianModel->save($data)) {
            dd('Gagal insert', $data, $this->antrianModel->errors());
        }

        return redirect()->to('/jadwal')->with('success', 'Pendaftaran berhasil.');
    }
}

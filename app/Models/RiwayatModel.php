<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatModel extends Model
{
    protected $table = 'riwayat_pemeriksaan'; //nama tabel
    protected $primaryKey = 'id_riwayat';

    protected $allowedFields = [
        'id_pasien',
        'id_dokter',
        'waktu',
        'diagnosis',
        'keluhan',
        'resep'
    ];

    public $useTimestamps = false;

    // ambil semua riwayat + nama dokter dan pasien
    public function getRiwayatLengkap()
    {
        return $this->select('riwayat_pemeriksaan.*, pasien.nama as nama_pasien, dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien= riwayat_pemeriksaan.id_pasien')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->findAll();
    }
}

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
        'tindakan',
        'keluhan',
        'resep',
        'catatan'
    ];

    public $useTimestamps = false;

    // ambil semua riwayat + nama dokter dan pasien
    public function getRiwayatByPasien($id_pasien)
    {
        return $this->select('riwayat_pemeriksaan.*, pasien.nama as nama_pasien, pasien.no_rm, pasien.jenis_kelamin, pasien.no_hp, pasien.tanggal_lahir, dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien = riwayat_pemeriksaan.id_pasien')
            ->join('dokter', 'dokter.id_dokter = riwayat_pemeriksaan.id_dokter')
            ->where('riwayat_pemeriksaan.id_pasien', $id_pasien)
            ->orderBy('waktu', 'DESC')
            ->findAll();
    }
}

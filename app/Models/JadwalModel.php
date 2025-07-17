<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal'; //nama tabel
    protected $primaryKey = 'id_jadwal';

    protected $allowedFields = [
        'id_dokter',
        'id_pasien',
        'tanggal_pemeriksaan',
        'status',
        'pemeriksaan',
        'created_ad'
    ];
    protected $useTimestamps = true;

    // relasi antar jadwal + nama dokter dan pasien

    public function getFullJadwal()
    {
        return $this->select('jadwal.*, dokter.nama as nama_dokter, pasien.nama as nama_pasien, antrian.no_RM')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien')
            ->join('antrian', 'antrian.id_antrian = jadwal.id_antrian')
            ->findAll();
    }
    // relasi: mengambil jadwal untuk pasien tertentu
    public function getJadwalByPasien($idPasien)
    {
        return $this->select('jadwal.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->where('jadwal.id_pasien', $idPasien)
            ->findAll();
    }
}

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
        'created_ad',
        'keluhan'
    ];
    protected $useTimestamps = true;

    // relasi antar jadwal + nama dokter dan pasien
    public function getFullJadwal()
    {
        return $this->select('jadwal.*, dokter.nama as nama_dokter, pasien.nama as nama_pasien, pasien.no_RM')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien')
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

    // untuk menampilkan data dihalaman pasien terjadwal role dokter
    public function getPasienTerjadwalByDokter($id_dokter)
    {
        return $this->select('jadwal.*, pasien.no_RM, pasien.nama as nama_pasien, dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->where('jadwal.id_dokter', $id_dokter)
            ->orderBy('jadwal.tanggal_pemeriksaan', 'ASC')
            ->findAll();
    }

    // public function getAntrianHariIni()
    // {
    //     return $this->db->table('antrian')
    //         ->select('antrian.*, pasien.nama as nama_pasien, pasien.no_RM')
    //         ->join('pasien', 'pasien.id_pasien = antrian.id_pasien')
    //         ->where('antrian.tanggal', date('Y-m-d'))
    //         ->orderBy('antrian.no_antrian', 'ASC')
    //         ->get()->getResultArray();
    // }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalDokterModel extends Model
{
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id_jadwal_dokter';
    protected $allowedFields = [
        'id_dokter',
        'hari',
        'shift',
        'created_at',
        'updated_at'
    ];

    // fungsi untuk mengambil dokter yang sedang praktik
    public function getDokterByTanggal($tanggal)
    {
        // ambil nama hari dalam bahasa Inggris dari tanggal yang dipilih
        $hariInggris = date('l', strtotime($tanggal));

        // gunakan nama hari bahasa inggris untuk mencari di databae karena didatabse menggunkan inggris
        return $this->db->table('jadwal_dokter')
            ->select('dokter.*')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hariInggris)
            ->groupBy('dokter.id_dokter')
            ->get()
            ->getResultArray();
    }

    // fungsi untuk mengambil dokter berdasarkan tanggal + shift
    public function getDokterByTanggalShift($tanggal, $shift)
    {
        $hariInggris = date('l', strtotime($tanggal));

        return $this->db->table('jadwal_dokter')
            ->select('dokter.id_dokter, dokter.nama')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hariInggris)
            ->where('jadwal_dokter.shift', $shift)
            ->get()
            ->getResultArray();
    }

    // function ambil jadwal dokter
    public function getJadwalWithDokter()
    {
        return $this->select('jadwal_dokter.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->orderBy('jadwal_dokter.hari', 'ASC')
            ->findAll();
    }

    public function getDokterByHari($hari)
    {
        return $this->select('dokter.id_dokter, dokter.nama, jadwal_dokter.hari')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $hari)
            ->findAll();
    }
}

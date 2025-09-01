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

    // function ambil jadwal dokter
    public function getJadwalWithDokter()
    {
        // Urutan hari dalam seminggu untuk sorting
        $orderHari = "FIELD(jadwal_dokter.hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";

        return $this->select('jadwal_dokter.id_jadwal_dokter, jadwal_dokter.hari, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->orderBy($orderHari) // mengurutkan berdasarkan hari
            ->orderBy('dokter.nama', 'ASC') // urutkan berdasarkan nama dokter
            ->findAll();
    }
}

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
        $hariInggris = date('l', strtotime($tanggal));
        $mapHari = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $this->db->table('jadwal_dokter')
            ->select('dokter.*')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->where('jadwal_dokter.hari', $mapHari[$hariInggris])
            ->groupBy('dokter.id_dokter')
            ->get()
            ->getResultArray();
    }
}

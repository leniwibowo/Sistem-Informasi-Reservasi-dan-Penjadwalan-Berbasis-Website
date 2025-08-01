<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table = 'antrian';
    protected $primaryKey = 'id_antrian';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_pasien',
        'id_antrian',
        'tanggal',
        'no_antrian',
        'no_RM',
        'status',
        'created_at',
        'updated_at', // perbaikan nama
        'id_jadwal',
        'keluhan',
        'id_tanggal'
    ];


    public function getAntrianHariIni()
    {
        return $this->db->table('antrian')
            ->select('antrian.*, pasien.nama as nama_pasien, pasien.no_RM')
            ->join('pasien', 'pasien.id_pasien = antrian.id_pasien')
            ->where('antrian.tanggal', date('Y-m-d'))
            ->orderBy('antrian.no_antrian', 'ASC')
            ->get()->getResultArray();
    }
}

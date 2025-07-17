<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table = 'antrian';
    protected $primaryKey = 'id_antrian';

    protected $allowedFields = [
        'id_pasien',
        'tanggal',
        'no_antrian',
        'no_RM',
        'status',
        'created_at',
        'updated_at', // perbaikan nama
        'id_jadwal',
        'keluhan'
    ];

    protected $useTimestamps = true;
    protected $returnType = 'array';

    public function getAntrianLengkap()
    {
        return $this->select('antrian.*, pasien.nama as nama_pasien')
            ->join('pasien', 'pasien.id_pasien = antrian.id_pasien')
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }

    public function getByTanggal($tanggal)
    {
        return $this->where('tanggal', $tanggal)->findAll();
    }
}

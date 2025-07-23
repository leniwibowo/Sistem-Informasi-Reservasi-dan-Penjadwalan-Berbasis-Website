<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table = 'antrian';
    protected $primaryKey = 'id_antrian';
    protected $useTimestamps = true;

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
}

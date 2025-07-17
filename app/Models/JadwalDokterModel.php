<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalDokterModel extends Model
{
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id_jadwal_dokter';

    protected $allowedFields = ['id_dokter', 'hari', 'created_at', 'update_at'];
    protected $useTimestamps = true;
}

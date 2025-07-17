<?php

namespace APP\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';   //nama tabel
    protected $primaryKey = 'id_admin';

    protected $allowedFields = ['id_pasien', 'id_jadwal', 'keluhan', 'nomor_antrian', 'status'];

    protected $useTimestamps = true;

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}

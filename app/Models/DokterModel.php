<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table = 'dokter'; //nama tabel
    protected $primaryKey = 'id_dokter';

    protected $allowedFields = ['nama', 'no_hp', 'username', 'password', 'created_ad'];
    protected $useTimestamps = true;

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}

<?php

namespace APP\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';   //nama tabel
    protected $primaryKey = 'id_admin';

    protected $allowedFields = ['nama', 'username', 'password', 'id_user'];


    protected $useTimestamps = false;

    // ambil username
    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}

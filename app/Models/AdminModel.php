<?php

namespace APP\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';   //nama tabel
    protected $primaryKey = 'id_admin';

    protected $allowedFields = ['nama', 'username', 'password'];


    protected $useTimestamps = false;

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}

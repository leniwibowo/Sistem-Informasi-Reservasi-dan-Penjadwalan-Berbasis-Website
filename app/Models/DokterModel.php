<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table = 'dokter'; //nama tabel
    protected $primaryKey = 'id_dokter';

    protected $allowedFields = ['nama', 'sip', 'no_hp', 'username', 'password', 'role', 'id_user'];
    protected $useTimestamps = false;

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getDokterByUserId($id_user)
    {
        // Cukup cari di tabel 'dokter' berdasarkan kolom 'id_user'
        // dan ambil baris pertama yang ditemukan.
        return $this->where('id_user', $id_user)->first();
    }
}

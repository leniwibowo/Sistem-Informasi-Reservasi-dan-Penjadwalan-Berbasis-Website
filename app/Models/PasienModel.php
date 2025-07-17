<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';

    protected $allowedFields = [
        'nama',
        'username',
        'password',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'no_RM',
        'nik',
        'created_at',
        'updated_at',
        'id_user'
    ];

    protected $useTimestamps = true;

    public function getByNIK($nik)
    {
        return $this->where('NIK', $nik)->first();
    }
}

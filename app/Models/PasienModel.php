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
        'golongan_darah',
        'diabetes',
        'penyakit_jantung',
        'alergi',
        'created_at',
        'updated_at',
        'id_user'
    ];

    protected $useTimestamps = true;

    public function getByNIK($nik)
    {
        return $this->where('nik', $nik)->first();
    }

    // function pasien pernah daftar
    public function getPasienPernahDaftar()
    {
        return $this->select('pasien.*')
            ->join('jadwal', 'jadwal.id_pasien = pasien.id_pasien')
            ->groupBy('pasien.id_pasien')
            ->findAll();
    }
    public function getDetailPasien($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }
}

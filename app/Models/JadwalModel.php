<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id_jadwal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang diizinkan untuk diisi secara massal
    protected $allowedFields    = [
        'id_pasien',
        'id_dokter',
        'tanggal_pemeriksaan',
        'shift',
        'pemeriksaan', // Catatan awal atau keluhan
        'status',
    ];

    // timestamp created_at dan updated_at
    protected $useTimestamps = true;

    // --- VALIDASI ---
    protected $validationRules = [
        'id_pasien'           => 'required|is_natural_no_zero',
        'id_dokter'           => 'required|is_natural_no_zero',
        'tanggal_pemeriksaan' => 'required|valid_date',
        'pemeriksaan'         => 'permit_empty|string|max_length[500]',
    ];

    // pesan error kustom untuk validasi
    protected $validationMessages = [
        'id_dokter' => [
            'required' => 'Anda harus memilih dokter yang tersedia.',
            'is_natural_no_zero' => 'Pilihan dokter tidak valid.',
        ],
        'tanggal_pemeriksaan' => [
            'required' => 'Anda harus memilih tanggal pemeriksaan.',
        ],
    ];

    // relasi antar jadwal + nama dokter dan pasien
    public function getFullJadwal()
    {
        return $this->select('jadwal.*, dokter.nama as nama_dokter, pasien.nama as nama_pasien, pasien.no_RM')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien')
            ->findAll();
    }

    // relasi: mengambil jadwal untuk pasien tertentu
    public function getJadwalByPasien($idPasien)
    {
        return $this->select('jadwal.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            ->where('jadwal.id_pasien', $idPasien)
            ->findAll();
    }

    // untuk menampilkan data dihalaman pasien terjadwal role dokter
    public function getPasienTerjadwalByDokter($id_dokter)
    {
        return $this->select('jadwal.*, pasien.no_RM, pasien.nama as nama_pasien, pasien.no_hp, dokter.nama as nama_dokter, antrian.no_antrian')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter')
            // ---  tambah LEFT JOIN ke tabel antrian ---
            ->join('antrian', 'antrian.id_jadwal = jadwal.id_jadwal', 'left')
            ->where('jadwal.id_dokter', $id_dokter)
            // --- tampilkan jadwal hari ini dan masa depan ---
            ->where('jadwal.tanggal_pemeriksaan >=', date('Y-m-d'))
            // --- tampilkan status yang masih aktif ---
            ->whereIn('jadwal.status', ['belum_hadir', 'Menunggu', 'Diperiksa'])
            ->orderBy('jadwal.tanggal_pemeriksaan', 'ASC')
            ->orderBy('antrian.no_antrian', 'ASC')
            ->findAll();
    }


    // mengambil pasien terjadwal 
    public function countPasienTerjadwalHariIni($id_dokter)
    {
        return $this->where('id_dokter', $id_dokter)
            ->where('tanggal_pemeriksaan', date('Y-m-d'))
            ->countAllResults();
    }


    // mengambil daftar pasien yang memiliki janji temu dengan dokter tertentu HARI INI.

    public function getJadwalJanjiTemuHariIni($id_dokter, $limit = 5)
    {
        return $this->select('jadwal.*, pasien.nama as nama_pasien, antrian.keluhan, antrian.no_antrian')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien', 'left')
            ->join('antrian', 'antrian.id_jadwal = jadwal.id_jadwal', 'left')
            ->where('jadwal.id_dokter', $id_dokter)
            ->where('jadwal.tanggal_pemeriksaan', date('Y-m-d'))
            ->where('jadwal.status !=', 'Selesai')
            ->orderBy('antrian.no_antrian', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    // mengambil seluruh jadal hari ini
    public function getFullJadwalHariIni($limit = null)
    {
        $builder = $this->select('jadwal.*, dokter.nama as nama_dokter, pasien.nama as nama_pasien, pasien.no_RM, antrian.no_antrian')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter', 'left')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien', 'left')
            ->join('antrian', 'antrian.id_jadwal = jadwal.id_jadwal', 'left')
            ->where('jadwal.tanggal_pemeriksaan', date('Y-m-d'))
            ->orderBy('antrian.no_antrian', 'ASC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->find();
    }
    // menambil jadwal yang akan datang
    public function getJadwalAkanDatang()
    {
        return $this->select('jadwal.*, pasien.nama as nama_pasien, pasien.no_RM, dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien = jadwal.id_pasien', 'left')
            ->join('dokter', 'dokter.id_dokter = jadwal.id_dokter', 'left')
            ->where('jadwal.tanggal_pemeriksaan >=', date('Y-m-d'))
            ->orderBy('jadwal.tanggal_pemeriksaan', 'ASC')
            ->findAll();
    }
}

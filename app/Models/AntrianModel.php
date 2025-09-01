<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table = 'antrian';
    protected $useTimestamps = false;
    protected $primaryKey = 'id_antrian';

    protected $allowedFields = [
        'id_pasien',
        'id_antrian',
        'tanggal',
        'no_antrian',
        'no_RM',
        'status',
        'created_at', // 
        'id_jadwal',
        'keluhan',
        'id_tanggal',
        'urutan_panggil'
    ];


    // app/Models/AntrianModel.php
    public function getAntrianHariIni()
    {
        return $this->db->table('antrian')
            ->select('antrian.id_antrian, antrian.no_antrian, antrian.status, pasien.nama as nama_pasien, pasien.no_RM')
            ->join('pasien', 'pasien.id_pasien = antrian.id_pasien')
            ->where('antrian.tanggal', date('Y-m-d'))
            // hanya ambil status 'menunggu' diperiksa'
            ->whereIn('antrian.status', ['Menunggu', 'Diperiksa'])
            ->orderBy('urutan_panggil', 'ASC') // Urutkan berdasarkan waktu panggil (untuk yang dilewati)
            ->orderBy('antrian.no_antrian', 'ASC') // Urutan utama berdasarkan nomor antrian
            ->get()->getResultArray();
    }

    // function status antrian pasien
    public function getStatusAntrianPasien($id_pasien)
    {
        $today = date('Y-m-d');
        $defaults = [
            'nomor_antrian_anda' => '-',
            'antrian_sekarang'  => '0',
            'sisa_antrian'      => '0',
        ];

        $antrian_pasien = $this->where('id_pasien', $id_pasien)
            ->where('tanggal', $today)
            ->first();

        if (!$antrian_pasien) {
            return $defaults;
        }

        // ambil antrian saat ini (yang sedang diperiksa)
        $antrian_aktif = $this->where('tanggal', $today)
            ->where('status', 'Diperiksa')
            ->orderBy('no_antrian', 'ASC')
            ->first();

        $nomor_antrian_sekarang = $antrian_aktif ? $antrian_aktif['no_antrian'] : '0';

        // hitung hanya pasien yang menunggu di depan
        $sisa_antrian = $this->where('tanggal', $today)
            ->where('status', 'Menunggu') // hanya status menunggu
            ->where('no_antrian <', (int)$antrian_pasien['no_antrian'])
            ->countAllResults();

        return [
            'nomor_antrian_anda' => $antrian_pasien['no_antrian'],
            'antrian_sekarang'  => $nomor_antrian_sekarang,
            'sisa_antrian'      => $sisa_antrian,
        ];
    }


    // function antrian berikutnya 
    public function getAntrianBerikutnya($limit = 5)
    {
        //  mengambil 'antrian.keluhan' bukan 'jadwal.keluhan'
        return $this->select('antrian.no_antrian, antrian.status, pasien.nama as nama_pasien, antrian.keluhan')
            ->join('pasien', 'pasien.id_pasien = antrian.id_pasien', 'left')
            ->join('jadwal', 'jadwal.id_jadwal = antrian.id_jadwal', 'left')
            ->where('antrian.tanggal', date('Y-m-d'))
            ->where('antrian.status', 'Menunggu') // Hanya yang statusnya menunggu
            ->orderBy('antrian.no_antrian', 'ASC')
            ->limit($limit) // 5 antrian teratas
            ->find();
    }
    // function nomor antrian 
    public function generateNomorAntrian($tanggal)
    {
        $lastAntrian = $this->where('tanggal', $tanggal)
            ->orderBy('no_antrian', 'DESC')
            ->first();

        if ($lastAntrian) {
            // jika sudah ada antrian, ambil nomor terakhir dan tambah 1
            return (int)$lastAntrian['no_antrian'] + 1;
        } else {
            // jika antrian pertama di hari itu, mulai dari 1
            return 1;
        }
    }
}

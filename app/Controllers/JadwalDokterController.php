<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JadwalDokterModel;
use App\Models\DokterModel;
use CodeIgniter\HTTP\ResponseInterface;

class JadwalDokterController extends BaseController

{

    protected $jadwalDokterModel;
    protected $dokterModel;

    public function __construct()
    {
        $this->jadwalDokterModel = new JadwalDokterModel();
        $this->dokterModel = new DokterModel();
    }

    // untuk perubahan jadwal dokter
    public function index()
    {
        $data = [
            'title' => 'Jadwal Dokter',
            'jadwal_dokter' => $this->jadwalDokterModel
                ->select('jadwal_dokter.*', 'dokter.nama')
                ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
                ->findAll()
        ];

        return view('jadwal_dokter/index', $data);
    }

    // menambahkan jadwal dokter
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Jadwal Dokter',
            'dokter' => $this->dokterModel->findAll()
        ];
        return view('jadwal_dokter/tambah', $data);
    }

    // simpan perubahan jadwal
    public function simpan()
    {
        $this->jadwalDokterModel->save([
            'id_dokter' => $this->request->getPost('id_dokter'),
            'hari' => $this->request->getPost('hari')
        ]);

        return redirect()->to('/jadwaldokter')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function hapus($id)
    {
        $this->jadwalDokterModel->delete($id);
        return redirect()->to('/jadwaldokter')->with('success', 'Jadwal berhasil dihapus');
    }
}

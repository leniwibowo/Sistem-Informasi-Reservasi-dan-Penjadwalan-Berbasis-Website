<?php

namespace App\Controllers;

use App\Models\PasienModel;


class Pasien extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }
    public function index()
    {
        // ambil data user dari session
        $pasien = session()->get('pasien');

        return view('dashboard', [
            'pasien' => $pasien
        ]);
    }

    public function profil()
    {
        $userId = session()->get('id_user');
        $pasien = $this->pasienModel->where('id_user', $userId)->first();

        if (!$pasien) {
            return redirect()->to('/dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        return view('pasien/profil', [
            'title' => 'Profil Pasien',
            'pasien' => $pasien
        ]);
    }
}

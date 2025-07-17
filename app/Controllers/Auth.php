<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{

    protected $Usermodel;
    protected $pasienModel;

    public function __construct()
    {
        $this->Usermodel = new UserModel();
        $this->pasienModel = new PasienModel();
    }

    // menampilkan form registrasi 

    public function register()
    {
        return view('auth/register');
    }

    // memproses simpan data register
    public function registerSave()
    {
        $data = $this->request->getPost();
        $pasienModel = new PasienModel();

        // mengambil no_RM terakhir dalam urutan database
        $lastPasien = $pasienModel->orderBy('id_pasien', 'DESC')->first();
        $nik = $this->request->getPost('nik');

        if ($lastPasien) {
            // mengambil angka dari no_RM terakhir dan increment

            $lastRM = intval(substr($lastPasien['no_RM'], 2));
            $newRM = 'RM' . str_pad($lastRM + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // jika data masih kosong
            $newRM = 'RM0001';
        }

        // validasi sederhana
        if (!$this->validate([
            'nik' => 'required|is_unique[pasien.nik]',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'golongan_darah' => 'required',
            'alergi' => 'required',
            'diabetes' => 'required',
            'penyakit_jantung' => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[5]',

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // simpan ke tabel user

        $this->Usermodel->insert([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'pasien'
        ]);

        $id_user = $this->Usermodel->getInsertID();

        // simpan ke tabel pasien
        $this->pasienModel->insert([
            'no_RM' => $newRM,
            'id_user' => $id_user,
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'no_hp' => $data['no_hp'],
            'alamat' => $data['alamat'],
            'golongan_darah' => $data['golongan_darah'],
            'alergi' => $data['alergi'],
            'diabetes' => $data['diabetes'],
            'penyakit_jantung' => $data['penyakit_jantung']
        ]);
        return redirect()->to('login')->with('success', 'Registrasi berhasil, silahkan login');
    }
    public function index()
    {
        return view('auth/login'); // menampilkan halaman login

    }

    public function loginAuth()
    {

        $session = session();
        $data = $this->request->getPost();

        $username = $data['username'];
        $password = $data['password'];
        $Usermodel = new UserModel();


        // $username = $this->request->getPost('username');
        // $password = $this->request->getPost('password');

        $user = $Usermodel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'isLoggedIn' => true,
                ];
                $session->set($sessionData);

                switch ($user['role']) {
                    case 'admin':
                        return redirect()->to('/admin/dashboard');
                    case 'dokter':
                        return redirect()->to('/dokter/dashboard');
                    case 'pasien':
                        return redirect()->to('/dashboard');
                    default:
                        return redirect()->to('/');
                }
            } else {
                return redirect()->back()->with('error', 'Password salah');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}



// {
        // $PasienModel = new PasienModel();

        // $username = $this->request->getPost('username');
        // $password = $this->request->getPost('password');

        // cari data pasien
        // $pasien = $PasienModel->where('username', $username)->first();

        // if ($pasien) {
            // cek password (jika belum has, langsung bandingkan)
            // if ($password == $pasien['password']) {
                // simpan data ke session
                // session()->set([
                    // 'id_pasien' => $pasien['id_pasien'],
                    // 'nama'     => $pasien['nama'],
                    // 'isLoggedIn' => true
                // ]);
                // return redirect()->to('/dashboard');
            // } else {
                // session()->setFlashdata('error', 'password salah!');
                // return redirect()->to('/');
            // }
        // } else {
            // session()->setFlashdata('error', 'Username tidak ditemukan!');
            // return redirect()->to('/');
        // }
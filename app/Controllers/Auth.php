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
        // 1efinisikan aturan validasi yang Lebih Ketat
        $rules = [
            'nik' => [
                'rules'  => 'required|exact_length[16]|numeric|is_unique[pasien.nik]',
                'errors' => [
                    'required'      => 'NIK wajib diisi.',
                    'exact_length'  => 'NIK harus terdiri dari 16 digit angka.',
                    'numeric'       => 'NIK hanya boleh berisi angka.',
                    'is_unique'     => 'NIK ini sudah terdaftar.'
                ]
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama lengkap wajib diisi.']
            ],
            'tanggal_lahir' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal lahir wajib diisi.',
                    'valid_date' => 'Format tanggal lahir tidak valid.'
                ]
            ],
            'no_hp' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'numeric'  => 'Nomor telepon hanya boleh berisi angka.'
                ]
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat wajib diisi.']
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[laki-laki,perempuan]',
                'errors' => ['required' => 'Jenis kelamin wajib dipilih.']
            ],
            'golongan_darah' => [
                'rules'  => 'required|in_list[A,B,AB,O,-]', // tambahkan '-' jika ada opsi 'Tidak Tahu'
                'errors' => [
                    'required' => 'Golongan darah wajib dipilih.',
                    'in_list' => 'Pilihan golongan darah tidak valid.'
                ]
            ],
            'alergi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Riwayat alergi wajib diisi. (Isi "Tidak Ada" jika tidak punya).']
            ],
            'diabetes' => [
                'rules'  => 'required|in_list[ya,tidak]',
                'errors' => ['required' => 'Riwayat diabetes wajib dipilih.']
            ],
            'penyakit_jantung' => [
                'rules'  => 'required|in_list[ya,tidak]',
                'errors' => ['required' => 'Riwayat penyakit jantung wajib dipilih.']
            ],
            'username' => [
                'rules'  => 'required|is_unique[users.username]',
                'errors' => [
                    'required'  => 'Username wajib diisi.',
                    'is_unique' => 'Username ini sudah digunakan, silakan pilih yang lain.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal harus 5 karakter.'
                ]
            ]
        ];

        // jalankan Validasi
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // jika validasi berhasil, lanjutkan dengan transaksi. trasfer data ke database
        $db = \Config\Database::connect();
        $db->transStart();

        // simpan ke tabel user 
        $this->Usermodel->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'pasien'
        ]);
        $id_user = $this->Usermodel->getInsertID();

        // buat nomor RM otomatis
        $lastPasien = $this->pasienModel->orderBy('id_pasien', 'DESC')->first();
        $newRM = $lastPasien ? 'RM' . str_pad(intval(substr($lastPasien['no_RM'], 2)) + 1, 4, '0', STR_PAD_LEFT) : 'RM0001';

        // simpan ke tabel pasien
        $this->pasienModel->insert([
            'no_RM' => $newRM,
            'id_user' => $id_user,
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'golongan_darah' => $this->request->getPost('golongan_darah'),
            'alergi' => $this->request->getPost('alergi'),
            'diabetes' => $this->request->getPost('diabetes'),
            'penyakit_jantung' => $this->request->getPost('penyakit_jantung')
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            // jika transaksi gagal, kembali dengan pesan error
            return redirect()->back()->withInput()->with('error', 'Registrasi gagal, terjadi kesalahan pada server.');
        }

        return redirect()->to('login')->with('success', 'Registrasi berhasil, silahkan login');
    }

    // untuk menampilkan halaman login
    public function index()
    {
        return view('auth/login');
    }

    // untuk menjalakan login 
    public function loginAuth()
    {
        $session = session();
        $data = $this->request->getPost();
        $username = $data['username'];
        $password = $data['password'];


        $Usermodel = new UserModel();
        $user = $Usermodel->where('username', $username)->first();

        // sistem akan membaca berdasarkan role 
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                log_message('debug', 'Session set after login: ' . print_r($sessionData, true));
                // menampilkan dashboard berdasarkan role
                $session->set($sessionData);
                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin/dashboard');
                }
                if ($user['role'] == 'dokter') {
                    $dokterModel = new \App\Models\DokterModel();
                    $dokter = $dokterModel->where('id_user', $user['id'])->first();
                    if ($dokter) {
                        $session->set('id_dokter', $dokter['id_dokter']);
                    }
                    return redirect()->to('/dokter/dashboard');
                } elseif ($user['role'] == 'pasien') {
                    return redirect()->to('/pasien/dashboard');
                }
            } else {
                $session->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    // lupa passord
    public function forgotPasswordForm()
    {
        return view('auth/forgot_password');
    }


    //memproses nomor HP, membuat token, dan mengarahkan ke halaman reset.
    public function processForgotPassword()
    {
        $no_hp = $this->request->getPost('no_hp');

        // cari pasien berdasarkan no_hp dari pasienModel
        $pasien = $this->pasienModel->where('no_hp', $no_hp)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Nomor HP tidak terdaftar.');
        }

        // cari user terkait
        $user = $this->Usermodel->find($pasien['id_user']);

        if (!$user) {
            return redirect()->back()->with('error', 'Akun pengguna tidak ditemukan.');
        }

        // token reset yang aman
        $token = bin2hex(random_bytes(20));

        // waktu kedaluwarsa token (misal: 15 menit)
        $expires = date('Y-m-d H:i:s', time() + 900);

        // Simpan token dan waktu kedaluwarsa ke database
        $this->Usermodel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expires_at' => $expires
        ]);

        // ini angsung redirect ke halaman reset.
        return redirect()->to('reset-password/' . $token)
            ->with('success', 'Silakan buat password baru Anda.');
    }


    // menampilkan form reset password jika token valid.

    public function resetPasswordForm($token)
    {
        // cari user berdasarkan token dan pastikan belum kedaluwarsa
        $user = $this->Usermodel->where('reset_token', $token)
            ->where('reset_token_expires_at >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Link reset password tidak valid atau sudah kedaluwarsa.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // memvalidasi dan menyimpan password baru.
    public function updatePassword()
    {
        // aturan validasi
        $rules = [
            'token'    => 'required',
            'password' => 'required|min_length[5]',
            'pass_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        // cari user berdasarkan token & pastikan belum kedaluwarsa (cek ulang)
        $user = $this->Usermodel->where('reset_token', $token)
            ->where('reset_token_expires_at >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Link reset password tidak valid atau sudah kedaluwarsa.');
        }

        // update password dan hapus token reset
        $this->Usermodel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->to('login')->with('success', 'Password Anda berhasil diubah. Silakan login kembali.');
    }


    // logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

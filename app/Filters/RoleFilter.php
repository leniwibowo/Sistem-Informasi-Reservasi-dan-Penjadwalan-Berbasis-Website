<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->get('isLoggedIn') && !$session->get('logged_in')) {
            return redirect()->to('/auth')->with('error', 'Silakan login terlebih dahulu.');
        }


        // Ambil role dari session
        $role = $session->get('role');


        // Cek apakah role sesuai dengan yang diizinkan
        if ($arguments && !in_array($role, $arguments)) {
            return redirect()->to('/auth')->with('error', 'Anda tidak memiliki akses.');
        }

        // Jika semua valid, lanjutkan request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada proses setelah response
    }
}

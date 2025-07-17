<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // jika user belum login arahke ke login

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        if ($arguments && !in_array(session()->get('role'), $arguments)) {
            return redirect()->to('/unauthorized');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

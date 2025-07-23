<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface as FiltersFilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $reques, $aruments = null)
    {
        $session = session();
        $role = $session->get('role');

        if ($aruments) {
            if (!in_array($role, $aruments)) {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki akeses.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $aruments = null) {}
}

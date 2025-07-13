<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $requiredRole = $arguments[0] ?? null;

        if (!session()->has('isLoggedIn') || !session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'))->with('failed', 'Anda harus login untuk mengakses halaman ini.');
        }

        if (session()->get('role') !== $requiredRole) {
            return redirect()->to(base_url('/'))->with('failed', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

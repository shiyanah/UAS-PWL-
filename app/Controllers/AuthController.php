<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface; // Pastikan ini di-use
use App\Models\UserModel; // Pastikan UserModel sudah di-use

class AuthController extends BaseController
{
    protected $user;

    function __construct()
    {
        // Memuat helper 'form' untuk penggunaan formulir
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
    {
        // Jika ada data POST yang dikirim (saat formulir login disubmit)
        if ($this->request->getPost()) {
            // Menetapkan aturan validasi
            $rules = [
                'username' => 'required|min_length[6]',
                // Perbaikan: Validasi password diatur sesuai kebutuhan.
                // Jika menggunakan password_verify, jangan gunakan 'numeric'
                // karena password_hash menghasilkan string.
                'password' => 'required|min_length[7]',
            ];

            // Melakukan validasi data
            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                // Mencari data pengguna berdasarkan username
                $dataUser = $this->user->where(['username' => $username])->first();

                if ($dataUser) {
                    // Memverifikasi password menggunakan password_verify() karena password disimpan dalam bentuk hash
                    if (password_verify($password, $dataUser['password'])) {
                        // Jika login berhasil, atur data sesi
                        session()->set([
                            'id_user' => $dataUser['id'], // Menambahkan ID pengguna ke sesi
                            'username' => $dataUser['username'],
                            'role' => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ]);

                        // Redirect ke halaman beranda
                        return redirect()->to(base_url('/'));
                    } else {
                        // Jika password salah
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    // Jika username tidak ditemukan
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                // Jika validasi gagal
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        // Tampilkan view login jika tidak ada data POST atau validasi gagal
        return view('v_login');
    }

    // Fungsi untuk logout
    public function logout()
    {
        // Hapus semua data sesi
        session()->destroy();
        // Redirect ke halaman login
        return redirect()->to('login');
    }
}

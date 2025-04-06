<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function produk()
    {
        return view('content/produk');
    }

    public function kategori($id = null)
    {
        $data['kat'] = [
            1 => 'Snack',
            2 => 'Makanan',
            3 => 'Minuman',
            4 => 'Bumbu dapur',
            5 => 'Alat Tulis'
        ];

        $kat = $data['kat'];
           // Jika ID kategori diberikan, tampilkan kategori yang sesuai
        if ($id !== null) {
            echo "<h1> " . ($kat[$id] ?? 'Kategori tidak ditemukan') . "</h1>";
           // echo "<a href='/kategori'>Kembali ke halaman kategori</a>";
            // Jika tidak ada ID yang diberikan, tampilkan semua kategori
        } else {
            echo "<h1>Ini adalah halaman kategori</h1>";
            echo "<ul>";
            foreach ($kat as $key => $value) {
                echo "<li><a href='/kategori/$key'>$value</a></li>";
            }
            echo "</ul>";
        }
        
    }
}

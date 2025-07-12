<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'nama' => 'Seporsi Mie Ayam Sebelum Mati',
                'harga'  => 79050,
                'jumlah' => 100,
                'foto' => 'mieayam.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Laut Bercerita',
                'harga'  => 97750,
                'jumlah' => 200,
                'foto' => 'lautbercerita.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Keajaiban Toko Kelontong Namiya',
                'harga'  => 110500,
                'jumlah' => 125,
                'foto' => 'tokokelontong.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Bintang',
                'harga'  => 105000,
                'jumlah' => 50,
                'foto' => 'bintang.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ]  
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product')->insert($item);
        }
    }
}

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

                'nama' => 'ASUS TUF A15 FA506NF',
                'harga'  => 10899000,
                'jumlah' => 5,
                'foto' => 'asus_tuf_a15.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Asus Vivobook 14 A1404ZA',
                'harga'  => 6899000,
                'jumlah' => 7,
                'foto' => 'asus_vivobook_14.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Lenovo IdeaPad Slim 3-14IAU7',
                'harga'  => 6299000,
                'jumlah' => 5,
                'foto' => 'lenovo_idepad_slim_3.jpg',

                'nama'   => 'Seporsi Mie Ayam Sebelum Mati',
                'harga'  => 79050,
                'jumlah' => 100,
                'foto'   => 'mieayam.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama'   => 'Laut Bercerita',
                'harga'  => 97750,
                'jumlah' => 200,
                'foto'   => 'lautbercerita.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama'   => 'Keajaiban Toko Kelontong Namiya',
                'harga'  => 110500,
                'jumlah' => 125,
                'foto'   => 'tokokelontong.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama'   => 'Bintang',
                'harga'  => 105000,
                'jumlah' => 50,
                'foto'   => 'bintang.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama'   => 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa',
                'harga'  => 91800,
                'jumlah' => 25,
                'foto'   => 'AtomicHabits.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama'   => 'Data Mining Dan Machine Learning Menggunakan Matlab Dan Pyth',
                'harga'  => 93500,
                'jumlah' => 30,
                'foto'   => 'DataMining.jpg',

                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product')->insert($item);
        }
    }

}


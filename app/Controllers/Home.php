<?php

namespace App\Controllers;

use App\Models\ProductModel;
// Hapus atau komen TransactionModel dan TransactionDetailModel jika tidak digunakan langsung di Home
// use App\Models\TransactionModel;
// use App\Models\TransactionDetailModel;

class Home extends BaseController
{
    protected $product;
    // Hapus atau komen ini jika tidak digunakan langsung di Home
    // protected $transaction;
    // protected $transaction_detail;

    function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        // Hapus atau komen ini jika tidak digunakan langsung di Home
        // $this->transaction = new TransactionModel();
        // $this->transaction_detail = new TransactionDetailModel();
    }


    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;
        return view('v_home', $data);
    }

    public function profile()
    {
        $username = session()->get('username');
        $data['username'] = $username; // Mengirimkan username ke view

        // DISESUAIKAN: Sekarang akan memuat view v_profile_extended.php
        return view('v_profile', $data);
    }

    // Metode FAQ Baru
    public function faq()
    {
        // Data FAQ (bisa diambil dari database jika mau lebih dinamis)
        $data['faqs'] = [
            [
                'question' => 'Bagaimana cara mendaftar di Toko Arunika?',
                'answer' => 'Anda bisa mendaftar dengan mengklik tombol "Daftar" di pojok kanan atas halaman, lalu mengisi formulir pendaftaran dengan data diri yang valid.'
            ],
            [
                'question' => 'Bagaimana cara melakukan pemesanan?',
                'answer' => 'Pilih produk yang Anda inginkan, klik tombol "Beli" atau "Tambah ke Keranjang", lalu ikuti langkah-langkah checkout hingga pembayaran selesai.'
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Kami menerima pembayaran melalui transfer bank (BCA, Mandiri), dan e-wallet (OVO, GoPay).'
            ],
            [
                'question' => 'Berapa lama waktu pengiriman?',
                'answer' => 'Waktu pengiriman bervariasi tergantung lokasi Anda dan metode pengiriman yang dipilih. Estimasi pengiriman akan ditampilkan saat checkout.'
            ],
            [
                'question' => 'Bagaimana cara melacak pesanan saya?',
                'answer' => 'Anda bisa melacak pesanan melalui halaman "Riwayat Pesanan" di profil Anda, atau dengan memasukkan nomor resi pada menu pelacakan.'
            ],
            [
                'question' => 'Apakah produk bisa dikembalikan atau ditukar?',
                'answer' => 'Produk dapat dikembalikan atau ditukar dalam waktu 7 hari setelah penerimaan, dengan syarat produk masih dalam kondisi asli dan belum terpakai. Silakan hubungi layanan pelanggan kami untuk informasi lebih lanjut.'
            ]
        ];

        $data['hlm'] = 'FAQ'; // Untuk judul halaman jika layout Anda menggunakannya
        return view('v_faq', $data);
    }

    public function hello($name = null)
    {
        $data['nama'] = $name;
        $data['title'] = "Judul halaman";
        return view('front', $data);
    }

    public function keranjang($id = null)
    {
        // Ini adalah fungsi yang tampaknya tidak terpakai atau duplikasi dari TransaksiController::index()
        // Anda mungkin ingin menghapusnya jika TransaksiController::index() sudah menangani keranjang
        $data = [
            'kat' => [
                'Alat Tulis',
                'Pakaian',
                'Pertukangan',
                'Elektronik',
                'Snack'
            ],
        ];
        $meta = ['title' => 'keranjang'];
        if (!is_null($id)) {
            echo $data['kat'][$id];
        } else {
            echo view('layout/header', $meta);
            echo view('layout/sidebar');
            echo view('content/keranjang', $data);
            echo view('layout/footer');
        }
    }
    public function password()
    {
        echo view('Views/hash');
    }
    // Hapus public function faq() jika Anda memiliki fungsi ini sebelumnya
    // public function faq()
    // {
    //     echo view('layout/faq');
    // }
}

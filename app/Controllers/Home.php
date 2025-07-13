<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel; // Pastikan ini di-use
use App\Models\TransactionDetailModel; // Pastikan ini di-use

class Home extends BaseController
{
    protected $product;
    protected $transaction; // Deklarasi properti transaction
    protected $transaction_detail; // Deklarasi properti transaction_detail

    function __construct()
    {
        // helper('form'); // Helper form dan number sudah dimuat di BaseController
        // helper('number'); // Jika Anda sudah memuatnya di BaseController, bisa dihapus di sini
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel(); // Inisialisasi model
        $this->transaction_detail = new TransactionDetailModel(); // Inisialisasi model
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
        $id_user = session()->get('id_user'); // Ambil id_user dari session
        $data['username'] = $username;

        // Mengambil data transaksi berdasarkan id_user
        $buy = $this->transaction->where('id_user', $id_user)->orderBy('created_at', 'DESC')->findAll();
        $data['buy'] = $buy;

        $product_details_in_transactions = []; // Mengubah nama variabel agar lebih jelas

        if (!empty($buy)) {
            foreach ($buy as $item) {
                // Mengambil detail transaksi dan join dengan tabel produk untuk mendapatkan nama, harga, foto
                $detail = $this->transaction_detail
                    ->select('transaction_detail.*, product.nama, product.harga, product.foto')
                    ->join('product', 'transaction_detail.product_id = product.id')
                    ->where('transaction_id', $item['id'])
                    ->findAll();

                if (!empty($detail)) {
                    $product_details_in_transactions[$item['id']] = $detail;
                }
            }
        }

        $data['product_details_in_transactions'] = $product_details_in_transactions; // Mengirimkan data ke view
        return view('v_profile', $data);
    }

    // Metode FAQ
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

    // Metode hello (jika masih digunakan)
    public function hello($name = null)
    {
        $data['nama'] = $name;
        $data['title'] = "Judul halaman";
        return view('front', $data);
    }

    // Metode keranjang (jika masih digunakan, tapi disarankan TransaksiController yang menanganinya)
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
}

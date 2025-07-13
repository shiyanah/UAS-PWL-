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
    public function faq()
    {
        echo view('layout/faq');
    }
}

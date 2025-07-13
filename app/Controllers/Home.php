<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;
    function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }


    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;
        return view('v_home', $data);
    }

    public function produk_detail($id)
    {
        $product = $this->product->find($id);

        if (!$product) {
            // Jika produk tidak ditemukan, kembali ke beranda atau tampilkan halaman 404
            return redirect()->to(base_url('/'))->with('failed', 'Produk tidak ditemukan.');
        }

        $data['product'] = $product;
        return view('v_produk_detail', $data);
    }

    public function profile()
    {
        $username = session()->get('username');
        $data['username'] = $username;

        $buy = $this->transaction->where('username', $username)->findAll();
        $data['buy'] = $buy;

        $product = [];

        if (!empty($buy)) {
            foreach ($buy as $item) {
                $detail = $this->transaction_detail->select('transaction_detail.*, product.nama, product.harga, product.foto')->join('product', 'transaction_detail.product_id=product.id')->where('transaction_id', $item['id'])->findAll();

                if (!empty($detail)) {
                    $product[$item['id']] = $detail;
                }
            }
        }

        $data['product'] = $product;

        return view('v_profile', $data);
    }
    
    // Perbaikan: Menghapus duplikasi fungsi 'public function profile()' yang menyebabkan syntax error.
    // Kode duplikasi yang ada di file Anda:
    // public function profile() 
    // {
    // ... (kode duplikasi)
    // }

    public function hello($name = null)
    {
        $data['nama'] = $name;
        $data['title'] = "Judul halaman";
        return view('front', $data);
    }

    public function keranjang($id = null)
    {
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
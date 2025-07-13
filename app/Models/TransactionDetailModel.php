<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    // Properti model yang telah diperbaiki dan digabungkan

    // Mengatur nama tabel dan primary key
    protected $table          = 'transaction_detail'; // Nama tabel singular
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Mengatur field yang diizinkan untuk diisi
    protected $allowedFields = [
        'transaction_id',
        'product_id',
        'nama_produk',  // Ditambahkan: untuk menyimpan nama produk
        'harga_satuan', // Ditambahkan: untuk menyimpan harga satuan
        'jumlah',       // Menggunakan 'jumlah'
        'diskon',
        'subtotal_harga',
    ];

    // Menggunakan timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Konfigurasi validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
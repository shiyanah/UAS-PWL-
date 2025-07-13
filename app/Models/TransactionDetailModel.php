<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table      = 'transaction_detail'; // DISESUAIKAN: nama tabel singular
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'transaction_id',
        'product_id',
        'nama_produk', // Tambahkan ini
        'harga_satuan', // Tambahkan ini
        'jumlah', // DISESUAIKAN: menggunakan 'jumlah' sesuai migrasi Anda
        'diskon',
        'subtotal_harga',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

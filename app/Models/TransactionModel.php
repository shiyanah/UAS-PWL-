<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transaction'; // DISESUAIKAN: nama tabel singular
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true; // Tambahkan ini untuk deleted_at

    protected $allowedFields = [
        'id_user', // Tambahkan jika ada relasi ke tabel user
        'username',
        'total_harga',
        'alamat',
        'kelurahan', // Tambahkan
        'layanan_pengiriman', // Tambahkan
        'ongkir',
        'status_pesanan', // DISESUAIKAN: kolom 'status' diubah menjadi 'status_pesanan' (jika di migrasi baru Anda sudah diubah)
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Tambahkan ini

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

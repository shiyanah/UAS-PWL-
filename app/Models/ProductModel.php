<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'harga',
        'jumlah',
        'foto',
        'deskripsi',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true; // Pastikan ini ada jika menggunakan created_at/updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

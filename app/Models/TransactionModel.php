<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    // Nama tabel di database
    protected $table          = 'transaction';
    // Nama primary key tabel
    protected $primaryKey     = 'id';
    // Menggunakan auto-increment untuk primary key
    protected $useAutoIncrement = true;
    // Tipe data yang dikembalikan dari query (misalnya 'array' atau 'object')
    protected $returnType     = 'array';
    // Mengaktifkan soft deletes (data tidak dihapus permanen, hanya ditandai sebagai dihapus)
    protected $useSoftDeletes = true; // Mengaktifkan soft deletes untuk kolom 'deleted_at'

    // Field-field yang diizinkan untuk diisi (mass assignment)
    protected $allowedFields = [
        'id_user',            // ID pengguna yang melakukan transaksi
        'username',           // Username pengguna
        'total_harga',        // Total harga transaksi
        'alamat',             // Alamat lengkap pengiriman
        'kelurahan',          // Nama kelurahan pengiriman
        'layanan_pengiriman', // Deskripsi layanan pengiriman
        'ongkir',             // Biaya ongkos kirim
        'status_pesanan',     // Status pesanan (misalnya 'menunggu pembayaran', 'diproses', 'selesai')
    ];

    // Mengaktifkan timestamps (created_at dan updated_at)
    protected $useTimestamps = true;
    // Nama kolom untuk waktu pembuatan record
    protected $createdField  = 'created_at';
    // Nama kolom untuk waktu pembaruan record terakhir
    protected $updatedField  = 'updated_at';
    // Nama kolom untuk waktu penghapusan record (digunakan dengan soft deletes)
    protected $deletedField  = 'deleted_at';

    // Aturan validasi untuk data sebelum disimpan
    protected $validationRules    = [];
    // Pesan kustom untuk aturan validasi
    protected $validationMessages = [];
    // Melewatkan validasi (true untuk melewatkan, false untuk mengaktifkan)
    protected $skipValidation     = false;
}
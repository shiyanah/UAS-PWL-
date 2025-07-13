<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql; // Tambahkan ini jika menggunakan RawSql untuk default value, tapi tidak wajib untuk ENUM

class AddColumnsToTransactionTables extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect(); // Mendapatkan instance database secara eksplisit

        // --- Additions to 'transaction' table ---
        // Add 'id_user' column
        if (!$db->fieldExists('id_user', 'transaction')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            $fields = [
                'id_user' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'id',
                ],
            ];
            $this->forge->addColumn('transaction', $fields);
        }

        // Add 'kelurahan' column
        if (!$db->fieldExists('kelurahan', 'transaction')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            $fields = [
                'kelurahan' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => true,
                    'after' => 'alamat',
                ],
            ];
            $this->forge->addColumn('transaction', $fields);
        }

        // Add 'layanan_pengiriman' column
        if (!$db->fieldExists('layanan_pengiriman', 'transaction')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            $fields = [
                'layanan_pengiriman' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => true,
                    'after' => 'kelurahan',
                ],
            ];
            $this->forge->addColumn('transaction', $fields);
        }

        // Add 'deleted_at' column for soft deletes
        if (!$db->fieldExists('deleted_at', 'transaction')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            $fields = [
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ];
            $this->forge->addColumn('transaction', $fields);
        }

        // --- Modify 'status' column in 'transaction' to ENUM 'status_pesanan' ---
        // Check if 'status' column exists and modify it
        if ($db->fieldExists('status', 'transaction')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            // Modify the column type and rename it
            $this->forge->modifyColumn('transaction', [
                'status' => [
                    'name' => 'status_pesanan', // Rename from 'status' to 'status_pesanan'
                    'type' => 'ENUM',
                    'constraint' => ['menunggu pembayaran', 'diproses', 'dikirim', 'selesai', 'dibatalkan'],
                    'default' => 'menunggu pembayaran',
                    'null' => false,
                ],
            ]);
        } else {
            // If for some reason 'status' doesn't exist, add 'status_pesanan' directly
            $fields = [
                'status_pesanan' => [
                    'type' => 'ENUM',
                    'constraint' => ['menunggu pembayaran', 'diproses', 'dikirim', 'selesai', 'dibatalkan'],
                    'default' => 'menunggu pembayaran',
                    'null' => false,
                    'after' => 'ongkir', // Adjust position as needed
                ],
            ];
            $this->forge->addColumn('transaction', $fields);
        }


        // --- Additions to 'transaction_detail' table ---
        // Add 'nama_produk' column
        if (!$db->fieldExists('nama_produk', 'transaction_detail')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            $fields = [
                'nama_produk' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => false,
                    'after' => 'product_id',
                ],
            ];
            $this->forge->addColumn('transaction_detail', $fields);
        }

        // Add 'harga_satuan' column
        if (!$db->fieldExists('harga_satuan', 'transaction_detail')) { // DISESUAIKAN: Menggunakan $db->fieldExists
            $fields = [
                'harga_satuan' => [
                    'type' => 'DOUBLE', // Match 'DOUBLE' from your Product migration
                    'null' => false,
                    'after' => 'nama_produk',
                ],
            ];
            $this->forge->addColumn('transaction_detail', $fields);
        }

        // 'jumlah' column already exists in your migration for transaction_detail,
        // so we don't need to add it again, but ensure it's used correctly.
    }

    public function down()
    {
        // Be cautious with down migrations that drop columns, especially on production.
        // For development, you might want to uncomment these for full rollback.
        // $this->forge->dropColumn('transaction', 'id_user');
        // $this->forge->dropColumn('transaction', 'kelurahan');
        // $this->forge->dropColumn('transaction', 'layanan_pengiriman');
        // $this->forge->dropColumn('transaction', 'deleted_at');
        // // Note: Reverting ENUM to INT and renaming back to 'status' can be complex.
        // // You might need a specific ALTER TABLE statement directly or accept data loss.
        // $this->forge->modifyColumn('transaction', [
        //     'status_pesanan' => [
        //         'name' => 'status', // Revert name
        //         'type' => 'INT', // Revert type
        //         'constraint' => 1,
        //         'null' => false,
        //         'default' => 0, // Assuming 0 was default for INT status
        //     ],
        // ]);
        // $this->forge->dropColumn('transaction_detail', 'nama_produk');
        // $this->forge->dropColumn('transaction_detail', 'harga_satuan');
    }
}

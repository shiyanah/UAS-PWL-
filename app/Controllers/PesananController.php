<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel; // Pastikan hanya ada satu kali
use App\Models\TransactionDetailModel; // Pastikan hanya ada satu kali
use App\Models\ProductModel; // Pastikan hanya ada satu kali

class PesananController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $productModel;

    public function __construct()
    {
        helper('number'); // Helper 'number' dimuat
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->productModel = new ProductModel();
    }

    // Halaman untuk menampilkan daftar pesanan (untuk Admin)
    public function index()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'))->with('failed', 'Akses ditolak. Anda bukan admin.');
        }

        $data['hlm'] = 'Manajemen Pesanan';
        $data['pesanan'] = $this->transactionModel->orderBy('created_at', 'DESC')->findAll();
        return view('v_manajemen_pesanan', $data);
    }

    // Halaman untuk menampilkan riwayat pesanan (untuk Pelanggan)
    public function riwayat()
    {
        $id_user = session()->get('id_user'); // Pastikan id_user disimpan di session saat login
        if (!$id_user) {
            return redirect()->to(base_url('login'))->with('failed', 'Anda harus login untuk melihat riwayat pesanan.');
        }

        $data['hlm'] = 'Riwayat Pesanan';
        $data['pesanan'] = $this->transactionModel->where('id_user', $id_user)->orderBy('created_at', 'DESC')->findAll();
        return view('v_riwayat_pesanan', $data);
    }

    // Menampilkan detail pesanan
    public function detail($id_pesanan)
    {
        $pesanan = $this->transactionModel->find($id_pesanan);

        if (!$pesanan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan.');
        }

        // Pastikan user hanya bisa melihat pesanannya sendiri (jika bukan admin)
        if (session()->get('role') !== 'admin' && $pesanan['id_user'] != session()->get('id_user')) {
            return redirect()->to(base_url('riwayat-pesanan'))->with('failed', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $detailPesanan = $this->transactionDetailModel
            ->select('transaction_detail.*, product.foto, product.nama as nama_produk, product.harga as harga_satuan') // Ambil nama dan harga produk
            ->join('product', 'transaction_detail.product_id = product.id', 'left')
            ->where('transaction_id', $id_pesanan)
            ->findAll();

        $data['hlm'] = 'Detail Pesanan';
        $data['pesanan'] = $pesanan; // Pastikan data pesanan utama (termasuk alamat) diteruskan
        $data['detail_pesanan'] = $detailPesanan;

        return view('v_detail_pesanan', $data);
    }

    // Fungsi untuk mengupdate status pesanan (hanya untuk Admin)
    public function updateStatus($id_pesanan)
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak. Anda bukan admin.']);
        }

        $status_baru = $this->request->getPost('status_pesanan');
        // Pastikan semua status yang mungkin ada di sini
        $validStatuses = ['menunggu pembayaran', 'menunggu verifikasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];

        if (!in_array($status_baru, $validStatuses)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status tidak valid.']);
        }

        $this->transactionModel->update($id_pesanan, ['status_pesanan' => $status_baru, 'updated_at' => date("Y-m-d H:i:s")]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status pesanan berhasil diperbarui.']);
    }

    // Fungsi untuk menghapus pesanan (opsional, hanya untuk admin)
    public function delete($id_pesanan)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('failed', 'Akses ditolak. Anda bukan admin.');
        }

        $transaction = $this->transactionModel->find($id_pesanan);
        if ($transaction && !empty($transaction['bukti_transfer'])) {
            $buktiPath = 'NiceAdmin/assets/bukti_transfer/' . $transaction['bukti_transfer'];
            if (file_exists($buktiPath)) {
                unlink($buktiPath);
            }
        }

        $this->transactionModel->delete($id_pesanan);
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    }
}

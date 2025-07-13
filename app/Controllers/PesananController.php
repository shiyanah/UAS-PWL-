<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;

class PesananController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $productModel;

    public function __construct()
    {
        helper('number');
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'))->with('failed', 'Akses ditolak. Anda bukan admin.');
        }

        $data['hlm'] = 'Manajemen Pesanan';
        $data['pesanan'] = $this->transactionModel->orderBy('created_at', 'DESC')->findAll();
        return view('v_manajemen_pesanan', $data);
    }

    public function riwayat()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to(base_url('login'))->with('failed', 'Anda harus login untuk melihat riwayat pesanan.');
        }

        $data['hlm'] = 'Riwayat Pesanan';
        $data['pesanan'] = $this->transactionModel->where('id_user', $id_user)->orderBy('created_at', 'DESC')->findAll();
        return view('v_riwayat_pesanan', $data);
    }

    public function detail($id_pesanan)
    {
        $pesanan = $this->transactionModel->find($id_pesanan);

        if (!$pesanan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan.');
        }

        if (session()->get('role') !== 'admin' && $pesanan['id_user'] != session()->get('id_user')) {
            return redirect()->to(base_url('riwayat-pesanan'))->with('failed', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $detailPesanan = $this->transactionDetailModel
            ->select('transaction_detail.*, product.foto')
            ->join('product', 'transaction_detail.product_id = product.id', 'left')
            ->where('transaction_id', $id_pesanan)
            ->findAll();

        $data['hlm'] = 'Detail Pesanan';
        $data['pesanan'] = $pesanan; // Pastikan data pesanan utama (termasuk alamat) diteruskan
        $data['detail_pesanan'] = $detailPesanan;

        return view('v_detail_pesanan', $data);
    }

    public function updateStatus($id_pesanan)
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak. Anda bukan admin.']);
        }

        $status_baru = $this->request->getPost('status_pesanan');
        $validStatuses = ['menunggu pembayaran', 'menunggu verifikasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];

        if (!in_array($status_baru, $validStatuses)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status tidak valid.']);
        }

        $this->transactionModel->update($id_pesanan, ['status_pesanan' => $status_baru, 'updated_at' => date("Y-m-d H:i:s")]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status pesanan berhasil diperbarui.']);
    }

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

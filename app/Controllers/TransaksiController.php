<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;
    protected $productModel;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }
    public function checkout()
    {
        if ($this->cart->totalItems() == 0) {
            return redirect()->to(base_url('keranjang'))->with('failed', 'Keranjang belanja Anda kosong!');
        }
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }
    public function getLocation()
    {
        $search = $this->request->getGet('search');

        try {
            $response = $this->client->request(
                'GET',
                'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . urlencode($search) . '&limit=50',
                [
                    'headers' => [
                        'accept' => 'application/json',
                        'key' => $this->apiKey,
                    ],
                ]
            );

            $body = json_decode($response->getBody(), true);
            return $this->response->setJSON($body['data']);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            log_message('error', 'Error in getLocation: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Failed to fetch locations. Please try again.']);
        }
    }


    public function getCost()
    {
        $destination = $this->request->getGet('destination');
        $weight = 1000;

        try {
            $response = $this->client->request(
                'POST',
                'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
                [
                    'multipart' => [
                        [
                            'name' => 'origin',
                            'contents' => '64999'
                        ],
                        [
                            'name' => 'destination',
                            'contents' => $destination
                        ],
                        [
                            'name' => 'weight',
                            'contents' => $weight
                        ],
                        [
                            'name' => 'courier',
                            'contents' => 'jne'
                        ]
                    ],
                    'headers' => [
                        'accept' => 'application/json',
                        'key' => $this->apiKey,
                    ],
                ]
            );

            $body = json_decode($response->getBody(), true);
            return $this->response->setJSON($body['data']);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            log_message('error', 'Error in getCost: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Failed to calculate cost. Please try again.']);
        }
    }


    public function buy()
    {
        if ($this->cart->totalItems() == 0) {
            return redirect()->to(base_url('keranjang'))->with('failed', 'Keranjang belanja Anda kosong!');
        }

        if ($this->request->getPost()) {
            $username = $this->request->getPost('username');
            $alamat_pengiriman = $this->request->getPost('alamat');
            $kelurahan_display = $this->request->getPost('kelurahan_text');
            $layanan_display = $this->request->getPost('layanan_text');
            $ongkir = $this->request->getPost('ongkir');
            $total_harga_cart = $this->cart->total();
            $total_final = $total_harga_cart + $ongkir;

            $id_user = session()->get('id_user') ?? null;

            if (!$id_user) {
                return redirect()->to(base_url('login'))->with('failed', 'Anda harus login untuk menyelesaikan pesanan.');
            }

            // 1. Simpan data transaksi utama
            $dataPesanan = [
                'id_user' => $id_user,
                'username' => $username,
                'alamat_pengiriman' => $alamat_pengiriman . ', ' . $kelurahan_display,
                'layanan_kurir' => $layanan_display,
                'ongkir' => $ongkir,
                'total_harga' => $total_final,
                'status_pesanan' => 'menunggu pembayaran', // Status awal
                'tanggal_transaksi' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->transaction->insert($dataPesanan);
            $transaction_id = $this->transaction->getInsertID();

            // 2. Simpan detail transaksi (item produk)
            foreach ($this->cart->contents() as $value) {
                $dataFormDetail = [
                    'transaction_id' => $transaction_id,
                    'product_id' => $value['id'],
                    'nama_produk' => $value['name'],
                    'harga_satuan' => $value['price'],
                    'jumlah' => $value['qty'],
                    'diskon' => 0,
                    'subtotal_harga' => $value['subtotal'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                $this->transaction_detail->insert($dataFormDetail);

                // Kurangi stok produk
                $product = $this->productModel->find($value['id']);
                if ($product) {
                    $newStock = $product['jumlah'] - $value['qty'];
                    $this->productModel->update($value['id'], ['jumlah' => $newStock]);
                }
            }

            // 3. Kosongkan keranjang setelah pesanan dibuat
            $this->cart->destroy();

            // 4. Redirect ke halaman pembayaran dengan ID transaksi
            return redirect()->to(base_url('pembayaran/' . $transaction_id))->with('success', 'Pesanan Anda berhasil dibuat! Silakan lanjutkan ke pembayaran.');
        }
        return redirect()->to(base_url('keranjang'))->with('failed', 'Metode tidak diizinkan.');
    }

    public function pembayaran($transaction_id)
    {
        $transaction = $this->transaction->find($transaction_id);

        if (!$transaction || $transaction['id_user'] != session()->get('id_user')) {
            return redirect()->to(base_url('/'))->with('failed', 'Transaksi tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $data['transaction'] = $transaction;
        $data['instruksi_pembayaran'] = "Silakan transfer total pembayaran ke rekening berikut:\n\n";
        $data['instruksi_pembayaran'] .= "Bank BCA\nNomor Rekening: 1234567890\nAtas Nama: Toko Arunika\n\n";
        $data['instruksi_pembayaran'] .= "Bank Mandiri\nNomor Rekening: 0987654321\nAtas Nama: Toko Arunika\n\n";
        $data['instruksi_pembayaran'] .= "Pastikan nominal transfer sesuai dengan total pembayaran Anda: " . number_to_currency($transaction['total_harga'], 'IDR', 'id_ID') . ".";

        return view('v_pembayaran', $data);
    }

    // --- FITUR BARU: KONFIRMASI PEMBAYARAN OLEH USER ---

    // Metode untuk menampilkan form konfirmasi pembayaran
    public function konfirmasiPembayaran($transaction_id)
    {
        $transaction = $this->transaction->find($transaction_id);

        // Pastikan transaksi ada, milik user, dan statusnya 'menunggu pembayaran'
        if (!$transaction || $transaction['id_user'] != session()->get('id_user') || $transaction['status_pesanan'] !== 'menunggu pembayaran') {
            return redirect()->to(base_url('riwayat-pesanan'))->with('failed', 'Transaksi tidak dapat dikonfirmasi atau status tidak sesuai.');
        }

        $data['transaction'] = $transaction;
        return view('v_konfirmasi_pembayaran', $data);
    }

    // Metode untuk memproses data konfirmasi pembayaran dari form
    public function prosesKonfirmasiPembayaran()
    {
        // Validasi input
        $rules = [
            'transaction_id' => 'required|numeric',
            'nama_pengirim_bank' => 'required|min_length[3]|max_length[100]',
            'bank_pengirim' => 'required|min_length[2]|max_length[50]',
            'bukti_transfer' => 'uploaded[bukti_transfer]|max_size[bukti_transfer,2048]|ext_in[bukti_transfer,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan user ke form dengan error
            return redirect()->back()->withInput()->with('failed', $this->validator->getErrors());
        }

        $transaction_id = $this->request->getPost('transaction_id');
        $nama_pengirim_bank = $this->request->getPost('nama_pengirim_bank');
        $bank_pengirim = $this->request->getPost('bank_pengirim');
        $file_bukti_transfer = $this->request->getFile('bukti_transfer');

        $transaction = $this->transaction->find($transaction_id);

        // Validasi ulang transaksi dan status
        if (!$transaction || $transaction['id_user'] != session()->get('id_user') || $transaction['status_pesanan'] !== 'menunggu pembayaran') {
            return redirect()->to(base_url('riwayat-pesanan'))->with('failed', 'Konfirmasi gagal: Transaksi tidak valid atau status tidak sesuai.');
        }

        // Proses upload file
        if ($file_bukti_transfer->isValid() && !$file_bukti_transfer->hasMoved()) {
            $fileName = $file_bukti_transfer->getRandomName();
            // Pastikan folder 'public/NiceAdmin/assets/bukti_transfer' ada dan memiliki izin tulis
            $file_bukti_transfer->move('NiceAdmin/assets/bukti_transfer', $fileName);

            $dataUpdate = [
                'bukti_transfer' => $fileName,
                'nama_pengirim_bank' => $nama_pengirim_bank,
                'bank_pengirim' => $bank_pengirim,
                'tanggal_konfirmasi' => date("Y-m-d H:i:s"),
                'status_pesanan' => 'menunggu verifikasi', // Ubah status menjadi menunggu verifikasi admin
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->transaction->update($transaction_id, $dataUpdate);

            session()->setFlashdata('success', 'Konfirmasi pembayaran berhasil dikirim! Pesanan Anda akan segera diverifikasi.');
            return redirect()->to(base_url('riwayat-pesanan/detail/' . $transaction_id));
        } else {
            session()->setFlashdata('failed', 'Gagal mengunggah bukti transfer. Pastikan Anda memilih file yang valid dan ukurannya tidak melebihi 2MB (JPG, JPEG, PNG).');
            return redirect()->to(base_url('konfirmasi-pembayaran/' . $transaction_id));
        }
    }
}

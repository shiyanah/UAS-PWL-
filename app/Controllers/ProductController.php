<?php

namespace App\Controllers;

use App\Models\ProductModel;
use Dompdf\Dompdf;

class ProductController extends BaseController
{
    protected $product;

    // Konstruktor: Inisialisasi model produk
    function __construct()
    {
        $this->product = new ProductModel();
    }


    // Menampilkan daftar produk
    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_produk', $data);
    }

    // Menambah produk baru
    public function create()
    {
        $dataFoto = $this->request->getFile('foto');

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'), 
            'created_at' => date("Y-m-d H:i:s")
        ];

        // Memproses upload foto jika valid
        if ($dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataForm['foto'] = $fileName;
            $dataFoto->move('NiceAdmin/assets/img/', $fileName);
        }

        $this->product->insert($dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Ditambah');
    }

    // Mengubah data produk
    public function edit($id)
    {
        $dataProduk = $this->product->find($id);

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        // Memeriksa apakah ada perubahan foto
        if ($this->request->getPost('check') == 1) {
            // Hapus foto lama jika ada
            if ($dataProduk['foto'] != '' and file_exists("img/" . $dataProduk['foto'] . "")) {
                unlink("img/" . $dataProduk['foto']);
            }

            // Upload foto baru jika valid
            $dataFoto = $this->request->getFile('foto');

            if ($dataFoto->isValid()) {
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('NiceAdmin/assets//img/', $fileName);
                $dataForm['foto'] = $fileName;
            }
        }

        $this->product->update($id, $dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Diubah');
    }

    // Menghapus produk
    public function delete($id)
    {
        $dataProduk = $this->product->find($id);

        // Hapus foto terkait jika ada
        if ($dataProduk['foto'] != '' and file_exists("img/" . $dataProduk['foto'] . "")) {
            unlink("img/" . $dataProduk['foto']);
        }

        $this->product->delete($id);

        return redirect('produk')->with('success', 'Data Berhasil Dihapus');
    }

    // Menampilkan detail produk dan rekomendasi produk lain
    public function detail($id)
    {
        // 1. Ambil data produk utama
        $product = $this->product->find($id);

        // 2. Ambil 4 produk rekomendasi (selain produk yang sedang dilihat)
        $recommendedProducts = $this->product
            ->where('id !=', $id)
            ->limit(4)
            ->findAll();

        // Kirim data ke view
        $data = [
            'product' => $product,
            'recommended_products' => $recommendedProducts,
        ];

        return view('v_produk_detail', $data);
    }

    // Mengunduh laporan produk dalam format PDF
    public function download()
    {
        // Ambil semua data produk dari database
        $product = $this->product->findAll();

        // Muat data ke file view PDF
        $html = view('v_produkPDF', ['product' => $product]);

        // Atur nama file PDF
        $filename = date('y-m-d-H-i-s') . '-produk';

        // Inisiasi Dompdf
        $dompdf = new Dompdf();

        // Muat konten HTML ke Dompdf
        $dompdf->loadHtml($html);

        // (Opsional) Atur ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'potrait');

        // Render HTML sebagai PDF
        $dompdf->render();

        // Output PDF yang dihasilkan
        $dompdf->stream($filename);
    }
}
<?php

namespace App\Controllers;

use App\Models\ProductModel;
use Dompdf\Dompdf;

class ProductController extends BaseController
{
    protected $product;

    function __construct()
    {
        $this->product = new ProductModel();
        helper('number');
        helper('form'); // Pastikan helper 'form' dimuat
    }

    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_produk', $data);
    }

    public function detail($id)
    {
        $product_detail = $this->product->find($id);

        if (!$product_detail) {
            // Ini akan menangani 404 jika ID produk tidak ditemukan
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }

        $recommended_products = $this->product
            ->where('id !=', $id)
            ->limit(3)
            ->orderBy('RAND()') // Menggunakan RAND() untuk rekomendasi acak
            ->findAll();

        $data['product_detail'] = $product_detail;
        $data['recommended_products'] = $recommended_products;

        return view('v_produk_detail', $data);
    }

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

        if ($dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataForm['foto'] = $fileName;
            $dataFoto->move('NiceAdmin/assets/img/', $fileName);
        }

        $this->product->insert($dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Ditambah');
    }

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

        if ($this->request->getPost('check') == 1) {
            // Hapus foto lama jika ada dan file_exists menggunakan path yang benar
            if ($dataProduk['foto'] != '' && file_exists("NiceAdmin/assets/img/" . $dataProduk['foto'])) {
                unlink("NiceAdmin/assets/img/" . $dataProduk['foto']);
            }

            $dataFoto = $this->request->getFile('foto');

            if ($dataFoto->isValid()) {
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('NiceAdmin/assets/img/', $fileName); // Perbaiki path
                $dataForm['foto'] = $fileName;
            }
        }

        $this->product->update($id, $dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $dataProduk = $this->product->find($id);

        // Hapus foto terkait jika ada dan file_exists menggunakan path yang benar
        if ($dataProduk['foto'] != '' && file_exists("NiceAdmin/assets/img/" . $dataProduk['foto'])) {
            unlink("NiceAdmin/assets/img/" . $dataProduk['foto']);
        }

        $this->product->delete($id);

        return redirect('produk')->with('success', 'Data Berhasil Dihapus');
    }

    public function download()
    {
        //get data from database
        $product = $this->product->findAll();

        //pass data to file view
        $html = view('v_produkPDF', ['product' => $product]);

        //set the pdf filename
        $filename = date('y-m-d-H-i-s') . '-produk';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content (file view)
        $dompdf->loadHtml($html);

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
}

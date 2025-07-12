<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf; // Pastikan Dompdf terinstal via Composer

class FilterStokController extends Controller // NAMA KELAS SESUAI LOG ERROR
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProductModel();
    }

    public function index()
    {
        $data['hlm'] = 'Filter Stok';
        $request = service('request');
        $startDate = $request->getGet('start_date');
        $endDate = $request->getGet('end_date');

        $builder = $this->produkModel->builder();

        if ($startDate) {
            $builder->where('created_at >=', $startDate . ' 00:00:00');
        }
        if ($endDate) {
            $builder->where('created_at <=', $endDate . ' 23:59:59');
        }

        // Data akan memiliki properti 'jumlah' jika itu nama kolomnya di DB
        $data['produk'] = $builder->get()->getResult(); 

        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        return view('v_filter_stok', $data); // PERBAIKAN: Nama view sesuai 'v_filter_stok'
    }

    public function exportPdf()
    {
        $request = service('request');
        $startDate = $request->getGet('start_date');
        $endDate = $request->getGet('end_date');

        $builder = $this->produkModel->builder();

        if ($startDate) {
            $builder->where('created_at >=', $startDate . ' 00:00:00');
        }
        if ($endDate) {
            $builder->where('created_at <=', $endDate . ' 23:59:59');
        }

        $produk = $builder->get()->getResult();

        // Siapkan data untuk view PDF
        $data['produk'] = $produk;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        // Load view HTML untuk PDF (Pastikan file ini ada: application/views/v_filter_stok_pdf.php)
        $html = view('v_filter_stok_pdf', $data); 

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'filter_stok_' . date('Ymd_His') . '.pdf';
        $dompdf->stream($filename, array("Attachment" => 0));
    }
}
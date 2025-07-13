<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <!-- Form Vertikal untuk Detail Pengiriman -->
        <?= form_open('buy', 'class="row g-3"') ?>
        <?= form_hidden('username', session()->get('username')) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>
        <div class="col-12">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" value="<?php echo session()->get('username'); ?>" readonly>
        </div>
        <div class="col-12">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>
        <div class="col-12">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select class="form-control" id="kelurahan" name="kelurahan" required></select>
            <input type="hidden" name="kelurahan_text" id="kelurahan_text"> <!-- Untuk menyimpan teks lengkap kelurahan -->
        </div>
        <div class="col-12">
            <label for="layanan" class="form-label">Layanan Pengiriman</label>
            <select class="form-control" id="layanan" name="layanan" required></select>
            <input type="hidden" name="layanan_text" id="layanan_text"> <!-- Untuk menyimpan teks lengkap layanan -->
        </div>
        <div class="col-12">
            <label for="ongkir" class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
        </div>
    </div>
    <div class="col-lg-6">
        <!-- Tabel Ringkasan Pesanan -->
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (!empty($items)) :
                        foreach ($items as $index => $item) :
                    ?>
                            <tr>
                                <td><?php echo $item['name'] ?></td>
                                <td><?php echo number_to_currency($item['price'], 'IDR') ?></td>
                                <td><?php echo $item['qty'] ?></td>
                                <td><?php echo number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                            </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <td>Subtotal</td>
                        <td><?php echo number_to_currency($total, 'IDR') ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>Total</td>
                        <td><span id="total"><?php echo number_to_currency($total, 'IDR') ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </div>
        </form><!-- Penutup Form Vertikal -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var ongkir = 0;
        var total = 0;
        hitungTotal(); // Panggil saat dokumen siap untuk inisialisasi total

        $('#kelurahan').select2({
            placeholder: 'Ketik nama kelurahan...',
            ajax: {
                url: '<?= base_url('get-location') ?>',
                dataType: 'json',
                delay: 1500,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id, // Hanya ID yang dikirim ke backend untuk get-cost
                                text: item.subdistrict_name + ", " + item.district_name + ", " + item.city_name + ", " + item.province_name + ", " + item.zip_code // Teks lengkap untuk ditampilkan dan disimpan di hidden input
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3
        });

        $("#kelurahan").on('change', function() {
            var id_kelurahan = $(this).val();
            // Simpan teks lengkap kelurahan ke hidden input
            $('#kelurahan_text').val($(this).find('option:selected').text());

            $("#layanan").empty();
            ongkir = 0; // Reset ongkir saat kelurahan berubah

            $.ajax({
                url: "<?= site_url('get-cost') ?>",
                type: 'GET',
                data: {
                    'destination': id_kelurahan, // Kirim hanya ID ke API RajaOngkir
                },
                dataType: 'json',
                success: function(data) {
                    $("#layanan").append($('<option>', { value: '', text: 'Pilih Layanan Pengiriman' })); // Opsi default
                    data.forEach(function(item) {
                        var text = item["description"] + " (" + item["service"] + ") : estimasi " + item["etd"] + "";
                        $("#layanan").append($('<option>', {
                            value: item["cost"], // Nilai ongkir
                            text: text // Teks yang ditampilkan
                        }));
                    });
                    // Trigger change pada layanan setelah option ditambahkan untuk menghitung total awal
                    $('#layanan').trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching cost:", error);
                    $("#layanan").empty();
                    $("#layanan").append($('<option>', { value: '', text: 'Tidak ada layanan tersedia' }));
                    ongkir = 0; // Pastikan ongkir 0 jika ada error
                    hitungTotal();
                }
            });
        });

        $("#layanan").on('change', function() {
            ongkir = parseInt($(this).val()) || 0; // Pastikan ongkir adalah angka, default 0 jika NaN
            // Simpan teks lengkap layanan ke hidden input
            $('#layanan_text').val($(this).find('option:selected').text());
            hitungTotal();
        });

        function hitungTotal() {
            total = ongkir + <?= $total ?>;

            $("#ongkir").val(ongkir);
            // Format angka total ke IDR
            $("#total").html("IDR " + total.toLocaleString('id-ID')); // Menggunakan toLocaleString untuk format IDR
            $("#total_harga").val(total);
        }
    });
</script>
<?= $this->endSection() ?>
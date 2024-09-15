<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?= base_url() . 'assets/fontawesome-free/css/all.min.css' ?>" rel="stylesheet" type="text/css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 Bootstrap 5 Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    
    <!-- CSS Kustom -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">

    <title>PMT Custom</title>
    <style>
    .navbar-custom {
        background-color: #1F497D;
    }
    
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .btn {
        color: #fff;
    }

    .form-select, .form-control {
        width: 100%; /* Mengatur agar elemen memenuhi kolom */
    }

    .dataTables_wrapper .dataTables_filter {
        float: right; /* Menggeser pencarian ke kanan */
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right; /* Menggeser pagination ke kanan */
    }

    .table-wrapper thead th {
        position: sticky;
        z-index: 1;
        background-color: #1F497D;
        color: #ffffff;
    }

    .readonly-textarea {
        background-color: #f8f9fa; /* Light background color to indicate readonly */
        border: 1px solid #ced4da; /* Border color to match disabled input */
    }
    .placeholder-text {
        color: #6c757d; /* Color for placeholder text */
        font-style: italic; /* Italicize placeholder text */
    }
    
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" style="font-size: 1.5rem;">PERMINTAAN PEMBELIAN BARANG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= base_url('c_dashboard/spk_rekap?id_mps=' . $mps); ?>" class="btn btn-secondary mb-2">Kembali</a>
            </div>
        </div>
    </nav>
    <!-- <div class="row" style="background-color: #1F497D;">
        <div class="col">
            <a href="<?= site_url().'c_dashboard/input_pmtppic/'.$kanban ?>" class="btn btn-primary mt-3">INPUT PMT</a>
        </div>
    </div> -->
    <br>
    <div class="container-fluid">
        <form action="<?= site_url().'c_dashboard/pmt_custom_temp' ?>" method="post"> 
            <div class="row">
            <?php if (isset($item)): ?>
                <div class="row">
                    <div class="col-md-1">
                        <label>No. Referensi</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($item->RefNo, ENT_QUOTES, 'UTF-8') ?>">
                    </div>  
                </div>
                <div class="row my-2">
                    <div class="col-md-1">
                        <label>Item</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($item->ItemName, ENT_QUOTES, 'UTF-8') ?>">
                    </div>  
                </div>
                <?php else: ?>
                    <!-- Tampilkan pesan jika $item tidak tersedia -->
                    <p>Item tidak ditemukan.</p>
                <?php endif; ?>

                <div class="col-md-1">
                    <label for="barang">Kode Barang</label>
                </div>      
                <div class="col-md-4">
                    <?php $barang = $this->db->query("SELECT * FROM inventory WHERE Category NOT IN('Finish Goods', 'Barang Jadi Rehab', 'Barang Jadi Furniture') ORDER BY ID ASC")->result()?>
                    <select name="id_barang" id="id_barang" class="form-select select2">
                        <option value=""> Pilih Barang </option>
                        <?php foreach($barang as $x): ?>
                            <option value="<?= $x->ID ?>">
                                <?php if($x->id_fina == "0.0") { ?>
                                    <?= $x->Item ?>
                                <?php } else { ?>
                                    <?= $x->id_fina ?>
                                <?php } ?> - <?= $x->ItemName ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-1">
                    <label for="jumlah">Jumlah</label>
                </div>      
                <div class="col-md-4">
                    <input type="number" class="form-control" name="jumlah" min="0">
                </div>
            </div>

            <div class="row my-2">
                <div class="col-md-1">
                    <label for="keterangan">Keterangan</label>
                </div>      
                <div class="col-md-4">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control readonly-textarea">
Merk: 
Spesifikasi: 
Ket: 
                    </textarea>
                </div>
            </div>

            <!-- <div class="row my-2">
                <div class="col-md-1">
                    <label for="keterangan">Keterangan</label>
                </div>      
                <div class="col-md-4">
                    <textarea name="keterangan" id="" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-1">
                    <label for="barang">Nama Pemesan</label>
                </div>      
                <div class="col-md-4">
                    <?php 
                        $pemesan = $this->db->query("SELECT * FROM user WHERE id IN('4', '126')")->result();
                    ?>
                    <select name="dept" id="dept" class="form-select select2">
                        <option value="">Pilih Nama</option>
                        <?php foreach($pemesan as $x): ?>
                            <option value="<?= htmlspecialchars($x->id, ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($x->nama_pengguna, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-1">
                    <br>
                </div>      
                <div class="col-md-1 d-grid">
                    <input type="submit" value="SUBMIT" class="btn btn-primary">
                </div>
            </div>
        </form>

        <br>

        <div class="row mt-2 mx-2">
            <div class="col mt-1">
                <div class="table-wrapper">
                    <table id="example" class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID Fina</th>
                                <th>Nama Barang</th>
                                <th>Kuantitas</th>
                                <th>Keterangan</th>
                                <th>Tgl Dibutuhkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($pmt as $x): ?>
                                <tr>
                                    <td><?= $x->id ?></td>
                                    <td><?= $x->id_fina ?></td>
                                    <td><?= $x->nabar ?></td>
                                    <td><?= $x->qty ?></td>
                                    <td><?= $x->keterangan ?></td>
                                    <td>
                                        <input type="date" name="tgl_dibutuhkan[]" class="form-control tgl-dibutuhkan" data-id="<?= $x->id ?>" value="<?= $x->tgl_dibutuhkan ?>">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $x->id ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#id_barang').select2({
                width: '100%' // Mengatur agar select2 memenuhi lebar kolom
            });

            $('#example').DataTable({
                "paging": true,         // Mengaktifkan pagination
                "searching": true,      // Mengaktifkan pencarian
                "info": true,           // Menampilkan informasi jumlah data
                "responsive": true      // Membuat tabel menjadi responsif
            });

            $('.tgl-dibutuhkan').change(function() {
                var id = $(this).data('id');
                var tgl_dibutuhkan = $(this).val();

                $.ajax({
                    url: '<?= site_url('c_dashboard/update_tgl_dibutuhkan') ?>',
                    type: 'POST',
                    data: {
                        id: id,
                        tgl_dibutuhkan: tgl_dibutuhkan
                    },
                    success: function(response) {
                        alert('Tanggal berhasil diperbarui');
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan. Coba lagi.');
                    }
                });
            });

            // Ketika tombol hapus diklik
            $('.btn-delete').on('click', function() {
                var id = $(this).data('id');
                var row = $(this).closest('tr');

                if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: '<?= site_url('c_dashboard/delete') ?>/' + id,
                        type: 'POST',
                        success: function(response) {
                            // Hapus baris dari tabel
                            row.remove();
                            alert('Data berhasil dihapus');
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus data');
                        }
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('keterangan');
            const defaultText = `Merk: \nSpesifikasi: \nKet: \n`;

            // Set default text if textarea is empty
            if (textarea.value.trim() === '') {
                textarea.value = defaultText;
            }

            // Prevent users from removing default text
            textarea.addEventListener('input', function () {
                const lines = textarea.value.split('\n');
                if (!lines[0].startsWith('Merk:')) {
                    textarea.value = defaultText;
                }
            });
        });
    </script>
</body>
</html>
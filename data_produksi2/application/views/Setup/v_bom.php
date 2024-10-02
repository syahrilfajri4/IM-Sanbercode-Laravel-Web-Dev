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
    
    <!-- Select2 Bootstrap 5 Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <title>B.O.M</title>

    <style>
    .navbar-custom {
        background-color: #1F497D;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .btn {
        color: #fff;
    }

    .table-wrapper {
        max-height: 800px;
    }

    .table-wrapper thead th {
        position: sticky;
        z-index: 1;
        background-color: #1F497D;
        color: #ffffff;
    }

    .pagination {
        justify-content: center;
    }

    .page-item.disabled .page-link {
        pointer-events: none;
        color: #6c757d;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" style="font-size: 1.5rem;">BILL OF MATERIALS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= site_url('c_dashboard') ?>" class="btn btn-secondary mb-2">Kembali</a>
            </div>
        </div>
    </nav>

<div class="col-sm-10 ms-3">
    <div class="row">
        <!-- PILIH BOM -->
        <form action="<?php echo base_url().'index.php/C_Bom/list_BOM/' ?>">
            <div class="col-sm-4">
                <label class="my-2" for="series">Bill Of Material (BOM) Produk :</label>
                <select class="form-select my-1 select2" name="Series" min=1 Required>
                    <?php if(empty($keyword)){ ?>    
                    <option selected disable value=0>
                        Pilih Barang
                    </option>
                    <?php } ?>
                    <?php foreach($series as $series) : ?>
                        <option <?php if(!empty($keyword)){ ?>selected<?php } ?> value="<?php echo $series->ID_BOM;?>"> 
                            <?php echo $series->Series.' - '.$series->Nama_Produk; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-2">
                <button type="Submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-secondary mx-2" href="<?= site_url('C_Bom/BOM') ?>">Reset</a>
                <?php if(empty($keyword)){ ?> 
                    <button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="fas fa-plus"></i> Master BOM
                    </button>
                <?php } ?>
            </div>
        </form>

    </div>

    <!-- TAMBAH MASTER BOM -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Input Master BOM</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="container">
                <form action="<?php echo base_url().'index.php/C_Bom/tambah_BOM/' ?>" method="post">
                <div class="row">
                    <label class="my-2" for="produk">Pilih Series Produk :</label>
                    <select class="form-select my-1 select2" name="produk" Required>
                        <option selected disable value=0>Silahkan Pilih Salah Satu</option>
                        <?php foreach($fg as $fg) : ?>
                            <option value="<?php echo $fg->ID;?>">
                                <?php if(!empty($fg->Series)) { ?>
                                    <?php echo $fg->Series.' - '.$fg->item_name; ?>
                                <?php } else {?>
                                    <?php echo $fg->item_name; ?>
                                <?php } ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row">
                    <label class="my-2" for="note">Catatan :</label>
                    <textarea class="form-control" id="note" name="note"></textarea>
                </div>
                <div class="my-5">
                    <button type="Submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-secondary" href="<?= site_url('C_Bom/BOM') ?>">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DETAIL BOM YANG DIPILIH -->
<div class="row mx-4">
    <?php if(!empty($keyword)){ ?>
        <div class="col-sm-8"></div>
            <div class="col-sm-4 btn-group float-end" role="group">
                <a class="btn btn-primary" href="<?= site_url('C_Bom/TambahItem/'.$series->ID_BOM) ?>">Tambah / Edit</a>
                <a class="btn btn-info" href="<?= site_url('Cetak_form/BOM/'.$series->ID_BOM) ?>">Cetak BOM</a>
                <a class="btn btn-warning" href="<?= site_url('C_struktur/list_struktur/'.$series->ID_BOM) ?>">Struktur Produk</a>
            </div>
        <div class="row my-2 mt-2">
            <div class="col">
                <div class="table-wrapper" style="overflow-x: auto; max-height: 500px;">
                    <table id="datatable" class="display table border border-3 table-hover">
                        <thead>
                            <tr>
                            <th scope="col" style="width:10%;">Kategori</th>
                            <th scope="col" style="width:10%;">Part ID</th>
                            <th scope="col" style="width:10%;">Kode WH</th>
                            <th scope="col" style="width:50;">Nama Barang</th>
                            <th scope="col" style="width:5%;">Satuan</th>
                            <th scope="col" style="width:5%;">Jumlah</th>
                            <th scope="col" style="width:5%;">Pro ID</th>
                            <th style="width:5%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $row) { ?>
                                <tr>
                                    <td><?= $row->Kategori?></td>
                                    <td><?= $row->ID_Part?></td>
                                    <td><?= $row->kode_part?></td>
                                    <td align=left><?= $row->nama_part?></td>
                                    <td><?= $row->Unit?></td>
                                    <td><?= $row->BOM1?></td>
                                    <td align=left>
                                        <?php if(!empty($row->Kode_Komp)) { ?>
                                            <?= $row->Kode_Komp?>
                                        <?php } elseif($row->Kategori == 'Component') {?>
                                            <a class="btn btn-success" href="<?= site_url('C_Bom/TambahProID/'.$series->ID_BOM.$row->ID_Part) ?>">+ProID</a></td>
                                        <?php }?>
                                        <td>
                                        <form action="<?php echo site_url('C_Bom/hapus/'.$series->ID_BOM.$row->ID_Part) ?>" method="post">
                                            <button type="submit" class="btn btn-secondary">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
            // Inisialisasi DataTable
            $('#datatable').DataTable({
                paging: false,          // Menonaktifkan pagination
                scrollY: '400px',       // Menentukan tinggi maksimal untuk scroll
                scrollCollapse: true,   // Mengizinkan tabel untuk menyusut jika data kurang
                ordering: false         // Menonaktifkan fungsi sorting
            });

            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: "Pilih Barang", // Placeholder pada Select2
                allowClear: true             // Mengizinkan clear selection
            });
        });
    </script>

</body>
        <script>
            window.setTimeout("waktu()", 1000);
 
            function waktu() {
            var tw = new Date();
            if (tw.getTimezoneOffset() == 0) (a=tw.getTime() + ( 7 *60*60*1000))
            else (a=tw.getTime());
            tw.setTime(a);
            var tahun= tw.getFullYear ();
            var hari= tw.getDay ();
            var bulan= tw.getMonth ();
            var tanggal= tw.getDate ();
            var hariarray=new Array("Minggu,","Senin,","Selasa,","Rabu,","Kamis,","Jum'at,","Sabtu,");
            var bulanarray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
            setTimeout("waktu()",1000);
            document.getElementById("tanggalwaktu").innerHTML = hariarray[hari]+" "+tanggal+" "+bulanarray[bulan]+" "+tahun+" Jam " + ((tw.getHours() < 10) ? "0" : "") + tw.getHours() + ":" + ((tw.getMinutes() < 10)? "0" : "") + tw.getMinutes() + (" W.I.B ");
            }
        </script>
</html>

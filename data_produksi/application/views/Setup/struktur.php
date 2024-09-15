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
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    
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
            <a class="navbar-brand" style="font-size: 1.5rem;">SUBKOMPONEN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= site_url('C_Bom') ?>" class="btn btn-secondary mb-2">Kembali</a>
            </div> -->
        </div>
    </nav>

    <div class="container mt-3">
            <?php foreach($series as $series) : ?>
            <div>
                <a class="btn btn-secondary float-end" href="<?= site_url('C_Bom/list_BOM1/'.$series->ID_BOM) ?>">Kembali</a>
            </div>
        <div class="row">
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="id_bom">Bill Of Material ID :</label>
                <input class="form-control" name="kode" value="<?= $series->ID_BOM ?>" type="number" disabled> 
            </div>
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="series">Series :</label>
                <input class="form-control" name="series" value="<?= $series->Series ?>" type="" disabled> 
            </div>
            <div class="col-sm-7 mb-2">
                <label class="form-label" for="nama_produk">Nama Produk :</label>
                <input class="form-control" name="nama_produk" value="<?= $series->Nama_Produk ?>" type="" disabled> 
            </div>

            <?php endforeach; ?>
        </div>
        <!-- <div class="btn-group float-end mt-3" role="group">
            <a class="btn btn-primary" href="<?= site_url('C_struktur/Tambah_Tampil/' . (isset($series->ID_BOM) ? $series->ID_BOM : '')) ?>">
                <i class="fas fa-plus"></i> Tambah
            </a>
            <a class="btn btn-info" href="<?= site_url('Cetak_form/struktur/' . (isset($series->ID_BOM) ? $series->ID_BOM : '')) ?>">
                Cetak BOC
            </a>
            <a class="btn btn-warning" href="<?= site_url('Cetak_form/struktur1/' . (isset($series->ID_BOM) ? $series->ID_BOM : '')) ?>">
                Cetak Struktur
            </a>
        </div> -->
        <div class="btn-group float-end mt-3" role="group">
            <a class="btn btn-primary" href="<?= site_url('C_struktur/Tambah_Tampil/'.$series->ID_BOM) ?>"><i class="fas fa-plus"></i> Tambah</a>
            <a class="btn btn-info" href="<?= site_url('Cetak_form/struktur/'.$series->ID_BOM) ?>">Cetak BOC</a>
            <a class="btn btn-warning" href="<?= site_url('Cetak_form/struktur1/'.$series->ID_BOM) ?>">Cetak Struktur</a>
            <a class="btn btn-success" href="<?= site_url('C_excel/struktur1/'.$series->ID_BOM) ?>">Excel Struktur</a>
        </div>
    </div>

    <div class="container">
        <?php if(!empty($keyword)){ ?>
            <div>
                <p class="mt-4">Detail Struktur Produk :</p>
            </div>
            <div class="table-wrapper" style="overflow-x: auto; max-height: 500px;">
                    <table id="datatable" class="display table border border-3 table-hover">
                    <thead class="bg-primary text-light" align=center>
                        <tr>
                        <th scope="col" style="width:10%;">Kategori</th>
                        <th scope="col" style="width:10%;">Pro ID</th>
                        <th scope="col" style="width:35%;">Nama Barang</th>
                        <th scope="col" style="width:5%;">Satuan</th>
                        <th scope="col" style="width:10%;">Jml BOM</th>
                        <th scope="col" style="width:10%;">Part ID</th>
                        <th style="width:25%;" ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $row) { ?>
                        <tr>
                            <td><?= $row->Kategori?></td>
                            <td><?= $row->Kode_Komp?></td>
                            <td align=left><?= $row->Nama_Komp?></td>
                            <td><?= $row->Satuan?></td>
                            <td><?= $row->Jumlah?></td>
                            <td><?= $row->kode_part?></td>
                            <td align=left>
                                <a class="btn btn-primary btn-sm" href="<?= site_url('C_struktur/list_sub/'.$row->Kode_Komp) ?>">Cek Detail</a>
                                <a class="btn btn-secondary btn-sm" href="<?= site_url('C_struktur/hapus/'.$row->Kode_Komp) ?>">Hapus</a>
                                <?php
                                    $link = 'assets/blueprint/'.$row->Kode_Komp.'.pdf';
                                ?>
                                <?php if(file_exists($link)) { ?>
                                    <a class="btn btn-warning btn-sm" href="http://192.168.10.18/produksi/assets/blueprint/<?= $row->Kode_Komp?>.pdf" target="blank">Blueprint</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>


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

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable
            ({
                paging: false,     // Menonaktifkan pagination
                scrollY: '400px',  // Menentukan tinggi maksimal untuk scroll
                scrollCollapse: true, // Mengizinkan tabel untuk menyusut jika data kurang
                ordering: false // Menonaktifkan fungsi sorting
            });
        });
    </script>
</html>
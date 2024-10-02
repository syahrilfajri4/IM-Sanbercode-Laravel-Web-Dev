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
            <a class="navbar-brand" style="font-size: 1.5rem;">Tambah Tahap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <form action="<?= site_url('C_master_barang/insert_tahap/')?>" method="post">
            <div class="row g-0">
                <div class="col-sm-1">
                    <label class= "form-label" for="GRUP">GRUP</label>
                    <input class="form-control" name="GRUP" 
                    <?php if(!empty($grup)) { ?>
                        value="<?php echo $grup ?>"
                    <?php } else { ?>
                        value="<?php echo $nomortahap ?>"
                    <?php } ?> type="text">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-1 mx-3">
                    <label class= "form-label" for="id_tahap">ID Tahap</label>
                    <input class="form-control" name="id_tahap" type="text">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-5 mx-3">
                    <label class= "form-label" for="Nama_Proses">Nama Proses</label>
                    <input class="form-control" name="Nama_Proses" type="text">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-3">
                    <label class= "form-label" for="WS">Workstation</label>
                    <select class="form-select" name="WS">
                        <option selected disabled value=" ">Pilih</option>
                        <?php foreach ($ws as $ws) { ?>
                        <option value="<?= $ws->ID?>"><?= $ws->Nama_WS.' - '.$ws->Divisi?></option>
                        <?php } ?>
                    </select>
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-1 mx-3">
                    <label class= "form-label" for="TAHAP">Tahap</label>
                    <input class="form-control" name="TAHAP" type="text">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-3 mt-3">
                    <label class= "form-label" for="durasi_dtk">Estimasi (Detik)</label>
                    <input class="form-control" name="durasi_dtk" type="text">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-3     mt-5 mx-3">
                    <a href="<?= site_url('C_master_barang/kembali_tampil_tahap')?>" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary" style="margin-left:5px;">Tambah</button>
                </div>
            </div>
        </form>
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

</html>
</html>
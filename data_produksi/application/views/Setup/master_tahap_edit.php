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
            <a class="navbar-brand" style="font-size: 1.5rem;">Edit Tahap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <form action="<?php echo base_url().'index.php/C_master_barang/update_tahap/'.$edit_tahap->ID?>" method="post">
            <div class="row g-0">
                <div class="col-sm-5">
                    <label class= "form-label" for="Nama_Proses">Nama Proses</label>
                    <input type="text" class="form-control" value="<?php echo $edit_tahap->Nama_Proses; ?>" name="Nama_Proses" id="">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-5 mx-3">
                    <label class= "form-label" for="WS">Workstation</label>
                    <!--<input type="text" class="form-control" value="<!?php echo $edit_tahap->WS; ?>" name="WS" id="">-->
                    <select class="form-select form-control" name="WS">
                        <option selected value="<?php echo $edit_tahap->WS; ?>"><?php echo $edit_tahap->workstation; ?></option>
                        <?php foreach ($ws as $ws) { ?>
                        <option value="<?= $ws->ID?>"><?= $ws->Nama_WS.' - '.$ws->Divisi?></option>
                        <?php } ?>
                    </select>
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-1">
                    <label class= "form-label" for="TAHAP">Tahap</label>
                    <input type="text" class="form-control" value="<?php echo $edit_tahap->TAHAP    ; ?>" name="TAHAP" id="">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-3 mt-3">
                    <label class= "form-label" for="durasi_dtk  ">Estimasi (Detik)</label>
                    <input type="text" class="form-control" value="<?php echo $edit_tahap->durasi_dtk; ?>" name="durasi_dtk" id="">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-1 mt-3 mx-3">
                    <label class= "form-label" for="GRUP">ID Tahap</label>
                    <input type="text" class="form-control" value="
                        <?php if(empty($edit_tahap->ID_TAHAP)) { ?>
                            0
                        <?php }else{ ?>
                            <?php echo $edit_tahap->ID_TAHAP; ?>
                        <?php } ?>
                    " name="id_tahap" id="">
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-1 mt-3 mx-3">
                    <label class= "form-label" for="GRUP">Grup</label>
                    <input type="text" class="form-control" value="<?php echo $edit_tahap->GRUP; ?>" name="GRUP" id="" disabled>
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-3 mt-3">
                    <label class= "form-label" for="Nama_Divisi">Nama Divisi</label>
                    <input type="text" class="form-control" value="<?php echo $edit_tahap->Nama_Divisi; ?>" name="Nama_Divisi" disabled>
                </div>
    <!--==================================================================================================================================-->
                <div class="col-sm-2 mx-3">
                    <a href="<?= site_url('C_master_barang/kembali_tampil_tahap/') ?>" class="btn btn-danger mt-5">Batal</a>
                    <button type="submit" class="btn btn-primary mt-5" style="margin-left:5px;">Update</button>
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
</html>
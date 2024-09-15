<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPU - PRODUKSI</title>
    <link href="<?= base_url('assets/img/shima_logo.jpg')?>" rel="icon">

    <!--Bootstrap Core CSS-->
    <link href="<?= base_url('assets/css/css/bootstrap.css'); ?>" rel="stylesheet">

    <!--data table css-->
    <link href="<?= base_url('assets/DataTables-1.11.4/css/dataTables.bootstrap5.css'); ?>" rel="stylesheet">

    <!--Bootstrap Core JS-->
    <script src="<?= base_url('assets/js/js/bootstrap.bundle.js'); ?>"></script>

    <!--Data table JS-->
    <script src="<?= base_url('assets/DataTables-1.11.4/js/dataTables.bootstrap5.js'); ?>"></script>

    <!--Other JS/Jquery-->
    <link rel="stylesheet" href="<?= base_url('assets/js/to_top.js')?>">

    <!--Other CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/css/nav.css')?>">
    <link href="<?= base_url() . 'assets/vendor/fontawesome-free/css/all.min.css' ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/select2/dist/css/select2.min.css' ?>">


    <script src="<?= base_url() . 'assets/vendor/jquery/jquery.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>


    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() . 'assets/vendor/jquery-easing/jquery.easing.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/select2/dist/js/select2.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/vendor/datatables/jquery.dataTables.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/vendor/datatables/dataTables.bootstrap4.min.js' ?>"></script>
</head>
<body>
    <?php $this->load->view("partial_/navigation.php") ?>

    <div class="container mt-5">
    <h5>Data Sub Struktur :</h5>
        <div class="row">
            <?php foreach($series1 as $series1) : ?>
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="kode_komp">Pro ID :</label>
                <input class="form-control" name="kode_komp" value="<?= $series1->Kode_Komp ?>" type="" disabled> 
            </div>
            <div class="col-sm-9 mb-2">
                <label class="form-label" for="nama_komp">Nama Barang :</label>
                <input class="form-control" name="nama_komp" value="<?= $series1->nama_komp ?>" type="" disabled> 
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <h5>Tambah / Edit Item Sub Struktur</h5>
            <p class="fst-italic">* masukan Pro ID yang akan ditambahkan atau diubah datanya</p>
        </div>
        <form action="<?= site_url('C_struktur/add_edit_sub/'.$series1->Kode_Komp) ?>" method="post">
        <div class="row">
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="kode_barang">Pro ID :</label>
                <input class="form-control" name="kode_barang" value="" type="number" required> 
            </div>
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="jumlah">Jumlah :</label>
                <input class="form-control" name="jumlah" value="" type="number" required>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-2">
                    <button type="Submit" class="btn btn-primary my-1">Simpan</button>
                    <a class="btn btn-secondary" href="<?= site_url('C_struktur/list_sub/'.$series1->Kode_Komp) ?>">Batal</a>
                    <a class="btn btn-success" data-bs-toggle="collapse" href="#collapseCari" role="button" aria-expanded="false" aria-controls="collapseCari">
                        Cari Barang
                    </a>
                </div>             
            </div>
        </div>
        </form>
        <hr>

        <div class="<?= $collapse ?>" id="collapseCari">
            <div class="card card-body">
                <form action="<?= site_url('C_struktur/Cari1/'.$series1->Kode_Komp) ?>" method="post">
                    <div class="row">
                        <div class="col-sm-8 mb-2">
                            <label class="form-label" for="cari">Cari Nama Barang :</label>
                            <input class="form-control" name="cari" value="" type="text">
                        </div>
                        <div class="col-sm-1 mb-2">
                            <br>
                            <!--<button type="Submit" class="btn btn-success mt-2">Submit</button>
                            <a class="btn btn-success mt-1" href="<!?= site_url('C_Bom/Cari/'.$series->ID_BOM) ?>">Cari</a>-->
                        </div> 
                    </div>
                </form> 

                <div>
                <select class="form-select" size="6" multiple aria-label="multiple select example">
                    <?php foreach($inventory as $inventory) : ?>
                        <option><?= $inventory->id.' - '.$inventory->item_name ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
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
</html>
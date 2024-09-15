<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("partial_/head.php") ?>
</head>
<body>
    <?php $this->load->view("partial_/navigation.php") ?>

    <div class="container mt-5">
    <h5>Data Sub Struktur :</h5>
        <div class="row">
            <?php foreach($series1 as $series1) : ?>
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="kode_komp">Pro ID :</label>
                <input class="form-control" name="kode_komp" value="<?= $series1->id ?>" type="" disabled> 
            </div>
            <div class="col-sm-9 mb-2">
                <label class="form-label" for="nama_komp">Nama Barang :</label>
                <input class="form-control" name="nama_komp" value="<?= $series1->item_name ?>" type="" disabled> 
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <h5>Tambah / Edit Bahan Baku</h5>
            <p class="fst-italic">* masukan Kode Bahan Baku yang akan ditambahkan atau diubah datanya</p>
        </div>
        <form action="<?= site_url('C_struktur/add_edit_bahan/'.$series1->id) ?>" method="post">
        <div class="row">
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="kode_barang">ID Barang :</label>
                <input class="form-control" name="kode_barang" value="" type="number" required> 
            </div>
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="jumlah">Ukuran Potong (mm):</label>
                <input class="form-control" name="jumlah" value="" type="number" required>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-2">
                    <button type="Submit" class="btn btn-primary my-1">Simpan</button>
                    <a class="btn btn-secondary" href="<?= site_url('C_struktur/list_bahan/'.$key) ?>">Batal</a>
                    <a class="btn btn-info" data-bs-toggle="collapse" href="#collapseCari" role="button" aria-expanded="false" aria-controls="collapseCari">
                        Cari Barang
                    </a>
                </div>             
            </div>
        </div>
        </form>
        <hr>

        <div class="<?= $collapse ?>" id="collapseCari">
            <div class="card card-body">
                <form action="<?= site_url('C_struktur/Cari2/'.$series1->id) ?>" method="post">
                    <div class="row">
                        <div class="col-sm-8 mb-2">
                            <label class="form-label" for="cari">Cari Nama Bahan Baku :</label>
                            <input class="form-control" name="cari" value="" type="text">
                        </div> 
                    </div>
                </form> 

                <div>
                <select class="form-select" size="6" multiple aria-label="multiple select example">
                    <?php foreach($inventory as $inventory) : ?>
                        <option><?= $inventory->id.' - '.$inventory->item_name.' = '.$inventory->stok ?></option>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("partial_/head.php") ?>
</head>
<body>
    <?php $this->load->view("partial_/navigation.php") ?>

    <h1 class="mx-3 mt-3">Detail Bahan Baku</h1>
    <hr>
    <div class="container">
        <div class="row">
            <?php foreach($series as $series) : ?>
            <div class="col-sm-2 mb-2">
                <label class="form-label" for="id_bom">Bill Of Material ID :</label>
                <input class="form-control" name="kode" value="<?= $series->ID_BOM ?>" type="number" disabled> 
            </div>
            <div class="col-sm-1 mb-2">
                <label class="form-label" for="series">Series :</label>
                <input class="form-control" name="series" value="<?= $series->Series ?>" type="" disabled> 
            </div>
            <div class="col-sm-8 mb-2">
                <label class="form-label" for="nama_produk">Nama Produk :</label>
                <input class="form-control" name="nama_produk" value="<?= $series->Nama_Produk ?>" type="" disabled> 
            </div>
        </div>
        <?php endforeach; ?>
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
            <div>
                <a class="btn btn-success float-end mt-3" href="<?= site_url('C_struktur/Tambah_Tampilbahan/'.$series1->id) ?>"><i class="fas fa-plus"></i> Tambah/Edit</a>
                <a class="btn btn-danger float-end mt-3 mx-2" href="<?= site_url('C_struktur/list_sub/'.$key1) ?>">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row mx-4">
            <div class="container">
                <p>Daftar Bahan Baku :</p>
            </div>
            <div class="col-xs-4 col-xs-offset-4 my-1">
                <table class="table table-strip table-hover">
                    <thead>
                        <tr align=center>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Satuan Material</th>
                            <th scope="col">Ukuran Material(mm)</th>
                            <th scope="col">Kebutuhan(mm/pcs)</th>
                            <th scope="col">Jumlah Potong</th>
                            <th scope="col">Sisa Potong (mm)</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $row) { ?>
                        <tr>
                            <td align=center><?= $row->Kode_Material?></td>
                            <td><?= $row->Nama_Material?></td>
                            <td align=center><?= $row->Satuan?></td>
                            <td align=center><?= $row->Measure ?></td>
                            <td align=center><?= $row->Ukuran?></td>
                            <?php 
                                $measure = $row->Measure;
                                $ukuran = $row->Ukuran;
                                $jumlah_pot = floor($measure/$ukuran);
                                $sisa = $measure - ($jumlah_pot * $ukuran);
                            ?>
                            <td align=center><?php echo $jumlah_pot ?></td>
                            <td align=center><?php echo $sisa ?></td>
                            <td> <?= $row->stok ?></td>
                            <td>
                                <a class="btn btn-danger" href="<?= site_url('C_struktur/hapus_bahan/'.$row->ID) ?>">Hapus</a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
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
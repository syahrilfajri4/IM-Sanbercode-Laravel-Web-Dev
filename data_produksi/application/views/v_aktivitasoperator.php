<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
    
    <title>Aktivitas Operator</title>
    <style>
    .navbar-custom {
        background-color: #1F497D;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .btn {
        color: #fff;
    }
    </style>
</head>
<body>

    <?php if ($this->session->flashdata('success')): ?>
        <script>
            alert('Data Berhasil Disimpan, Silahkan Aktivasi');
        </script>
    <?php endif; ?>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" style="font-size: 1.5rem;">Laporan Aktivitas Operator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= site_url('c_dashboard') ?>" class="btn btn-secondary mb-2">Kembali</a>
            </div>
        </div>
    </nav>

        <!-- Form Filter -->
        <div class="container-fluid">
        <form method="POST" enctype="multipart/form-data">
            <div class="row" style="background-color: #1F497D;">
                <div class="col-5 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Nama Operator</label></div>
                        <div class="col-8">
                            <select name="operator" id="dataUser" class="form-control">
                                <option value="0"> Pilih Operator </option>
                                <?php foreach($dataUser as $key => $value):?>
                                <option value="<?php echo $value->ID; ?>"><?php echo $value->ID . ' ' . $value->NAMA; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>  
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Bulan</label></div>
                        <div class="col">
                        <select class="form-control" name="bulan">
                            <?php foreach($list_months as $key => $value):?>
                                <option <?= $key == $bulan ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach ?>
                         </select>
                        </div>
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Tahun</label></div>
                        <div class="col">
                        <select class="form-control" name="tahun">
                            <?php foreach($list_years as $key => $value):?>
                                <option <?= $key == $tahun ? 'selected' : '' ?> value="<?= $value ?>"><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                        </div>
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col d-grid"><button type="submit" class="btn btn-primary">Filter</button></div>
                        <div class="col d-grid"><button type="reset" class="btn btn-primary" onclick="window.location.href='<?php echo site_url('C_monitoring'); ?>'">Reset</button></div>  
                    </div>
                </div>
            </div>
        </form>
        <div class="row mt-2">
            <!-- TABLE DAFTAR SPK -->
            <div class="col-12">
                <div class="overflow-auto" style="height:550px;">
                    <table id="datatable" class="display table-sm table border border-3" style="width: 100%;">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No. Kanban</th>
                                <th scope="col">No. SPK</th>
                                <th align="center" width="400px" scope="col">Proses</th>
                                <th align="center" width="200px" scope="col">Barang</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Jumlah SPK</th>
                                <th scope="col">Kuantitas</th>
                                <th scope="col">Estimasi</th>
                                <th scope="col">Realisasi</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dataOperator)) : ?>
                                <?php foreach ($dataOperator as $row) : 
                                    // Pastikan variabel $row berisi array yang valid dengan kunci 'jam_mulai' dan 'jam_selesai'
                                    $date1 = new DateTime($row->jam_mulai);
                                    $date2 = new DateTime($row->jam_selesai);

                                    // Hitung selisih waktu antara dua DateTime object
                                    $interval = $date1->diff($date2);

                                    // Konversi selisih waktu ke dalam menit
                                    $differenceInMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                                    // Tentukan periode istirahat
                                    $restStart = new DateTime($date1->format('Y-m-d') . ' 12:00:00');
                                    $restEnd = new DateTime($date1->format('Y-m-d') . ' 13:00:00');

                                    // Periksa apakah waktu kerja mencakup periode istirahat
                                    if ($date1 <= $restStart && $date2 >= $restEnd) {
                                        // Kurangi waktu istirahat (60 menit) jika periode istirahat sepenuhnya termasuk dalam waktu kerja
                                        $differenceInMinutes -= 60;
                                    } elseif ($date1 <= $restStart && $date2 > $restStart && $date2 < $restEnd) {
                                        // Kurangi sebagian waktu istirahat jika waktu kerja berakhir di tengah periode istirahat
                                        $differenceInMinutes -= ($date2->diff($restStart)->h * 60 + $date2->diff($restStart)->i);
                                    } elseif ($date1 > $restStart && $date1 < $restEnd && $date2 >= $restEnd) {
                                        // Kurangi sebagian waktu istirahat jika waktu kerja dimulai di tengah periode istirahat
                                        $differenceInMinutes -= ($restEnd->diff($date1)->h * 60 + $restEnd->diff($date1)->i);
                                    }
                                ?>
                                    <tr>
                                        <td>0</td>
                                        <td><?= $row->id_spk; ?></td>
                                        <td><?= $row->nama_proses; ?></td>
                                        <td><?= $row->item_name; ?></td>
                                        <td><?= $row->unit; ?></td>
                                        <td>0</td>
                                        <td><?= $row->jumlah; ?></td>
                                        <td>0</td>
                                        <td><?= $differenceInMinutes; ?></td> <!-- Menampilkan hasil perhitungan selisih waktu -->
                                        <td><?= $row->jam_mulai; ?></td>
                                        <td><?= $row->jam_selesai; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="11">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
<footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</footer>
</html>
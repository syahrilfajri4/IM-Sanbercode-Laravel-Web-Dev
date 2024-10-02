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

    <!-- DataTables CSS untuk Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.2/css/buttons.dataTables.min.css"> -->
    
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
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 10; /* Atur z-index sesuai kebutuhan */
    }
        th {
        text-align: center; /* Pusatkan teks dalam th */
    }
    .lembur {
        background-color: yellow !important;
    }

    </style>
</head>
<body>

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
        <form method="POST" role="form" id="FormInput">
            <div class="row" style="background-color: #1F497D;">
                <div class="col-5 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Nama Operator</label></div>
                        <div class="col-8">
                            <select name="operator" id="dataUser" class="form-control">
                                <option value="0"> Pilih Operator </option>
                                <?php foreach($dataUser as $key => $value):?>
                                    <option <?= $value->ID == $operator ? 'selected' : '' ?> value="<?php echo $value->ID ?>"><?php echo $value->ID . ' ' . $value->NAMA; ?></option>
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
                <div class="overflow-auto" style="height:650px;">
                    <table id="datatable" class="display table-sm table border border-3" style="width: 100%;" data-ordering="false">
                        <thead class="table-primary sticky-header">
                        <tr>
                            <th scope="col" class="text-center align-middle">No. SPK</th>
                            <th align="center" width="200px" scope="col" class="text-center align-middle">Barang</th>
                            <th align="center" width="200px" scope="col" class="text-center align-middle">SubKom</th>
                            <th align="center" width="400px" scope="col" class="text-center align-middle">Proses</th>
                            <th scope="col" class="text-center align-middle">Satuan</th>
                            <!-- <th scope="col" class="text-center align-middle">Jumlah SPK</th> -->
                            <th scope="col" class="text-center align-middle">Kuantitas</th>
                            <th scope="col" class="text-center align-middle">Realisasi Menit</th>
                            <th scope="col" class="text-center align-middle">Mulai</th>
                            <th scope="col" class="text-center align-middle">Selesai</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dataOperator as $value) : ?>
                                <?php
                                    // Pastikan untuk mengakses data sebagai array
                                    $date1 = new DateTime($value['jam_mulai']);
                                    $date2 = new DateTime($value['jam_selesai']);
                                    
                                    // Hitung selisih waktu antara dua DateTime object
                                    $interval = $date1->diff($date2);
                                    
                                    // Konversi selisih waktu ke dalam menit
                                    $differenceInMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                                    // Tentukan periode istirahat
                                    $restStart = new DateTime($date1->format('Y-m-d') . ' 12:00:00');
                                    $restEnd = new DateTime($date1->format('Y-m-d') . ' 13:00:00');

                                    // Periksa apakah waktu kerja mencakup periode istirahat
                                    if ($date1 <= $restStart && $date2 >= $restEnd) {
                                        $differenceInMinutes -= 60; // Jika istirahat sepenuhnya termasuk
                                    } elseif ($date1 <= $restStart && $date2 > $restStart && $date2 < $restEnd) {
                                        $differenceInMinutes -= ($date2->diff($restStart)->h * 60 + $date2->diff($restStart)->i); // Jika istirahat sebagian termasuk
                                    } elseif ($date1 > $restStart && $date1 < $restEnd && $date2 >= $restEnd) {
                                        $differenceInMinutes -= ($restEnd->diff($date1)->h * 60 + $restEnd->diff($date1)->i); // Jika kerja mulai di tengah istirahat
                                    }
                                    // Tentukan apakah waktu selesai lebih dari jam 4 sore pada hari biasa, atau hari Sabtu lebih dari jam 15:00, atau hari Minggu
                                    $isWeekdayOvertime = $date2->format('H:i') > '16:00' && $date2->format('w') >= 1 && $date2->format('w') <= 5;
                                    $isSaturdayOvertime = $date2->format('H:i') > '15:00' && $date2->format('w') == 6;
                                    $isSunday = $date2->format('w') == 0;
                                    
                                    $isOvertime = $isWeekdayOvertime || $isSaturdayOvertime || $isSunday;
                                ?>
                                <tr class="<?php echo $isOvertime ? 'lembur' : ''; ?>">
                                    <td><?php echo $value['id_spk']; ?></td>
                                    <td><?php echo $value['ItemName']; ?></td>
                                    <td><?php echo $value['item_name']; ?></td>
                                    <td><?php echo $value['nama_proses']; ?></td>
                                    <td><?php echo $value['unit']; ?></td>
                                    <!-- <td><?php echo $value['jumlah_spk']; ?></td> -->
                                    <td><?php echo $value['jumlah']; ?></td>
                                    <td><?php echo $differenceInMinutes; ?></td>
                                    <td><?php echo $value['jam_mulai']; ?></td>
                                    <td><?php echo $value['jam_selesai']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons JS (Versi terbaru saja) -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


    <script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "paging": true, // Aktifkan pagination jika diinginkan
            "scrollY": "600px", // Tinggi scroll
            "scrollCollapse": true, // Membuat tabel bisa menyusut jika data sedikit
            "info": false, // Menonaktifkan informasi
            "searching": true, // Mengaktifkan fitur pencarian
            "dom": 'Bfrtip', // Menyertakan tombol
            "buttons": [
                'copy', 
                'excel'
            ]
        });
    });

    </script>

</body>
</html>
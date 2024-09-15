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
            <a class="navbar-brand" style="font-size: 1.5rem;">Detail Tahap <?php echo $grup ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= site_url('C_Bom') ?>" class="btn btn-secondary mb-2">Kembali</a>
            </div> -->
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-end my-3 mb-2">
            <a href="<?= site_url($tampil) ?>" class="btn btn-danger" style="margin-right:5px;">Kembali</a>
            <a href="<?= site_url('C_master_barang/tambah_tahap') ?>" class="btn btn-success">Tambah <i class="fas fa-plus"></i></a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="table-wrapper" style="overflow-x: auto; max-height: 500px;">
        <table id="datatable" class="display table border border-3 table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <!-- <th scope="col">ID Tahap</th> -->
                    <th scope="col">Nama Proses</th>
                    <th scope="col">Tahap</th>
                    <th scope="col">Grup</th>
                    <th scope="col">Workstation</th>
                    <th scope="col">Estimasi (Detik)</th>
                    <th scope="col">Nama Divisi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tahap as $row) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8') ?></td>
                    <!-- <td><?= htmlspecialchars($row['ID_TAHAP'], ENT_QUOTES, 'UTF-8') ?></td> -->
                    <td><?= htmlspecialchars($row['Nama_Proses'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['TAHAP'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['GRUP'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['workstation'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['durasi_dtk'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['Nama_Divisi'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="<?= site_url('C_master_barang/edit_tahap/'.$row['ID']) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= site_url('C_master_barang/hapus_tahap/'.$row['ID']) ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
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
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

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.2/css/buttons.dataTables.min.css">

    <title>Monitoring SPK</title>
    <style>
    .navbar-custom {
        background-color: #1F497D;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .btn {
        color: #fff;
    }

    thead th {
        text-align: center;
        vertical-align: middle; /* Vertikal tengah */
    }
    .col-center {
        text-align: center;
        vertical-align: middle; /* Vertikal tengah */
    }
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 10; /* Atur z-index sesuai kebutuhan */
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
            <a class="navbar-brand" style="font-size: 1.5rem;"><b>Monitoring Surat Perintah Kerja</b></a>
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
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Divisi</label></div>
                        <div class="col-8">
                            <?php
                                // Mengambil data pengguna dari database
                                $divisi = $this->db->query("SELECT * FROM erp_pro_divisi WHERE ID IN (1, 2, 3, 4, 5, 6, 7, 9)")->result();
                            ?>
                            <select class="form-control" name="divisi" id="">
                                <option disabled selected>PILIH DIVISI</option>
                                <?php foreach($divisi as $value): ?>
                                    <option value="<?php echo $value->ID; ?>"><?php echo $value->ID . ' - ' . $value->{'Nama Divisi'}; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Status SPK</label></div>
                        <div class="col">
                        <select class="form-control" name="bulan">
                            <option value="">Aktif</option>
                            <option value="">Stop</option>
                            <option value="">Kadaluarsa</option>
                         </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col"><label style="color:#ffffff;">Status Pekerjaan</label></div>
                        <div class="col">
                        <select class="form-control" name="bulan">
                            <option value="">WIP</option>
                            <option value="">Selesai</option>
                         </select>
                        </div>
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Tanggal Mulai</label></div>
                        <div class="col">
                            <input name="tglmulai" id="tanggalMulai" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col"><label style="color:#ffffff;">Tanggal Akhir</label></div>
                        <div class="col">
                            <input name="tglselesai" id="tanggalSelesai" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col d-grid"><button type="submit" class="btn btn-primary">Filter</button></div>
                        <div class="col d-grid"><button type="reset" class="btn btn-primary" onclick="window.location.href='<?php echo site_url('C_MonitoringSpk'); ?>'">Reset</button></div>  
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col">
                            <label class="date-time" style="color:#ffffff;"><i>Update Data :</i></label>
                            <i><?php
                            // Menampilkan tanggal dan jam saat ini
                            echo '<span id="currentDateTime" style="color:#ffffff;">' . date('d M Y H:i:s') . '</span>';
                            ?></i>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="date-time" style="color:#ffffff;"><i>Terakhir Input :</i></label>
                            <i><?php
                            // Menampilkan tanggal dan jam saat ini
                            echo '<span id="currentDateTime" style="color:#ffffff;">' . date('d M Y H:i:s') . '</span>';
                            ?></i>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <div class="row mt-2">
            <!-- TABLE DAFTAR SPK -->
            <div class="col-12">
                <div class="overflow-auto" style="height:550px;">
                    <table id="datatable" class="display table-sm table border border-3" style="width: 100%;">
                        <thead class="table-primary sticky-header" data-ordering="false">
                            <tr>
                                <th scope="col">Divisi</th>
                                <th scope="col">Tgl SPK</th>
                                <th scope="col">Tgl Mulai</th>
                                <th scope="col">No SPK</th>
                                <th align="center" width="100px" scope="col">Proses</th>
                                <th align="center" width="50px" scope="col">Barang</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Kuantitas</th>
                                <th scope="col">Realisasi</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">Pembaruan</th>
                                <th scope="col">Est Hari</th>
                                <th scope="col">Est Jam</th>
                                <th scope="col">Est Menit</th>
                                <th scope="col">Jml Operator</th>
                                <th scope="col">Terlambat Mulai</th>
                                <th scope="col">Pekerjaan Berhenti</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
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

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "processing": true, 
                "serverSide": true,
                "searching": true, // Mengaktifkan fitur pencarian
                "ajax": {
                    "url": "<?php echo site_url('C_MonitoringSpk/get_data_produksi_serverside'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "departemen" },
                    { "data": "tanggal_record" },
                    { "data": "tgl_mulai", "defaultContent": "0" },  // Kolom dengan nilai default
                    { "data": "barcode" },
                    { "data": "id_tahap" },
                    { "data": "id_komponen" },
                    { "data": "satuan", "defaultContent": "0" },
                    { "data": "jumlah" },
                    { "data": "realisasi", "defaultContent": "0" },
                    { "data": "saldo", "defaultContent": "0" },
                    { "data": "pembaruan", "defaultContent": "0" },
                    { "data": "est_hari", "defaultContent": "0" },
                    { "data": "est_jam", "defaultContent": "0" },
                    { "data": "est_menit", "defaultContent": "0" },
                    { "data": "jml_operator", "defaultContent": "0" },
                    { "data": "terlambat_mulai", "defaultContent": "0" },
                    { "data": "pekerjaan_berhenti", "defaultContent": "0" },
                    { "data": "status" }
                ]
            });
        });
        
        //Atur Tanggal
        function updateDateTime() {
            const now = new Date();
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const dateTimeString = now.toLocaleString('id-ID', options);
            document.getElementById('currentDateTime').textContent = dateTimeString;
        }

        // Update date and time immediately
        updateDateTime();
        // Update every second
        setInterval(updateDateTime, 1000);
    </script>
</body>
<footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</footer>
</html>
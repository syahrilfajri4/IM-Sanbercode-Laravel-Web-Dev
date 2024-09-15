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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.2/css/buttons.dataTables.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 Bootstrap 5 Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <!-- JSZip (untuk format Excel) -->
    
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
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Divisi</th>
                                <th scope="col">Tgl SPK</th>
                                <th scope="col">Tgl Mulai</th>
                                <th scope="col">No SPK</th>
                                <th scope="col">No Kanban</th>
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
                                <th scope="col">Tgl Berlaku</th>
                            </tr>
                        </thead>
                        <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>

    <!-- JSZip (untuk format Excel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>

    <!-- pdfmake (opsional, untuk ekspor PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    <!-- Buttons HTML5 JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export Excel'
                    }
                ],
                // Pastikan jumlah kolom di sini sesuai dengan jumlah kolom di HTML
                columns: [
                    { data: 'divisi' },
                    { data: 'tgl_spk' },
                    { data: 'tgl_mulai' },
                    { data: 'no_spk' },
                    { data: 'no_kanban' },
                    { data: 'proses' },
                    { data: 'barang' },
                    { data: 'satuan' },
                    { data: 'kuantitas' },
                    { data: 'realisasi' },
                    { data: 'saldo' },
                    { data: 'pembaruan' },
                    { data: 'est_hari' },
                    { data: 'est_jam' },
                    { data: 'est_menit' },
                    { data: 'jml_operator' },
                    { data: 'terlambat_mulai' },
                    { data: 'pekerjaan_berhenti' },
                    { data: 'status' },
                    { data: 'tgl_berlaku' }
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
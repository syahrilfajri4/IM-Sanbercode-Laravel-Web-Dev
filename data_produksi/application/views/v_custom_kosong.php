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

    <style>
        /* Style untuk border tabel */
        .table-bordered th, .table-bordered td {
            border: 1px solid black !important;
            table-layout: fixed;
        }

        /* Style untuk bagian tanda tangan */
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
        }

        /* Style untuk footer cetakan */
        .print-footer {
            margin-top: 20px;
            text-align: right;
        }

        /* Tabel dengan lebar 100% dan tata letak tetap */
        table {
            table-layout: fixed;
            width: 100%;
        }

        /* Pengaturan untuk th dan td */
        .table th,
        .table td {
            border: 1px solid black;
            padding: 18px; /* Menambah padding vertikal untuk membuat baris lebih lebar */
            text-align: left;
        }

        /* Style untuk cetak */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .signature, .print-footer {
                page-break-inside: avoid;
            }

            tr.vendorListHeading {
                background-color: #e2e3e5 !important;
                -webkit-print-color-adjust: exact; /* Khusus untuk WebKit */
            }

            /* Tabel cetak */
            table {
                visibility: visible;
                table-layout: fixed;
                width: 100%;
            }

            table, th, td {
                page-break-inside: avoid;
                padding: 1px;
                border: 1px solid #000;
                text-align: center;
                vertical-align: middle;
            }
        }

        /* Lebar kolom */
        .job-column {
            width: 100px; /* Ganti dengan lebar yang diinginkan */
        }
        .subkom-column {
            width: 100px; /* Ganti dengan lebar yang diinginkan */
        }
        .spk-column {
            width: 100px; /* Ganti dengan lebar yang diinginkan */
        }

        /* Warna background untuk thead */
        thead.thead-custom {
            background-color: #e2e3e5;
        }

        /* Style untuk thead */
        thead th {
            padding: 2px;
            border-width: 1px;
            text-align: center;
            vertical-align: middle;
        }
    </style>

</head>
<body onload="window.print()" style="font-size:12px;">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <h3 class="text-center">Surat Perintah Kerja</h3>

        <!-- Info Top -->
        <?php if (isset($form_data)): ?>
        <div class="row mt-5 mb-2">
                <div class="col-6" style="margin-top:-10px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="head bg-secondary-subtle mr-1">Nomor SPK</th>
                            <td><?php echo htmlspecialchars($form_data->{'Barcode_Series'}); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6" style="margin-top:-10px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px; " class="head bg-secondary-subtle mr-1">Nama Produk</th>
                            <td><?php echo htmlspecialchars($form_data->{'ID Komponen'}); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6" style="margin-top:-12px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="head bg-secondary-subtle mr-1">Divisi</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6" style="margin-top:-12px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="bg-secondary-subtle mr-1">Jumlah Produk</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-top:-10px;">
                <div class="col-6" style="margin-top:-10px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="bg-secondary-subtle mr-1">Tanggal Mulai</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <div class="card border border-white">
                        <div class="px-2 mx-2">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <p>Data tidak ditemukan.</p>
            <?php endif; ?>

        <!-- Table Section -->
        <table class="table table-bordered">
        <thead class="text-center">
            <tr class="vendorListHeading">
                <th class="spk-column" style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">No. SPK</th>
                <th class="subkom-column" style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Nama Subkom</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Operator</th>
                <th class="job-column" style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Job</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Jumlah</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Estimasi Menit</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Tgl/Jam Mulai</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Tgl/Jam Selesai</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">Realisasi</th>
                <th style="padding: 2px; border-width: 1px; text-align: center; vertical-align: middle;">BHP/Ket.</th>
            </tr>
        </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- Tambahkan baris sesuai kebutuhan -->
                <?php
            // Menampilkan 20 baris kosong
                for ($i = 0; $i < 15; $i++) {
                    echo "<tr>";
                    echo "<td></td>"; // Nomor SPK
                    echo "<td></td>"; // Nama Subkomponen
                    echo "<td></td>"; // Operator
                    echo "<td></td>"; // Job
                    echo "<td></td>"; // Mesin
                    echo "<td></td>"; // Jumlah
                    echo "<td></td>"; // Estimasi (Menit)
                    echo "<td></td>"; // Tgl Mulai
                    echo "<td></td>"; // Tgl Selesai
                    echo "<td></td>"; // Realisasi
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature mt-3">
            <div>
                <p>Manager / Wakil Produksi</p>
                <br>
                <br>
                <p>_____________________</p>
            </div>
            <div>
                <p>Pemberi Tugas<br>Supervisor</p>
                <br>
                <p>_____________________</p>
            </div>
            <div>
                <p>Diterima,<br>Kepala Seksi</p>
                <br>
                <p>_____________________</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="print-footer mt-1">
            <p>Dicetak Oleh: <strong>Sony</strong> <strong>Samuel</strong></p>
            <p>Halaman 1 Dari 1</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

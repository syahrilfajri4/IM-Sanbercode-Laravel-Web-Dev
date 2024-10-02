<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px; /* Ukuran font lebih kecil */
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
        }
        .section-header {
            font-weight: bold;
        }
        .section-subheader {
            padding-left: 20px;
        }
        .section-operator {
            text-align: left;
            padding-left: 10px;
        }
        .table th {
            background-color: #e2e3e5;
        }
        /* Style untuk bagian tanda tangan */
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
            margin-bottom: 20px; /* Atur ulang jarak di bawah tanda tangan */
        }
        /* Style untuk footer cetakan */
        .print-footer {
            margin-top: 10px;
            text-align: right;
        }

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
        }
        .section-header {
            font-weight: bold;
            text-align: left;
        }

        .section-subheader {
            padding-left: 20px;
            text-align: left;
        }
        .table-bordered {
            font-size: 10px; /* Mengatur ukuran font */
        }
        .table-bordered thead {
            background-color: #e2e3e5; /* Warna biru untuk latar belakang */
            /* color: white; Warna teks putih untuk kontras */
        }
    </style>
</head>
<body>
<!-- <body onload="window.print()" style="font-size:12px;"> -->
<div class="container" style="max-width: 800px; margin: 0 auto;">
    <h2 style="text-align: center;">Surat Perintah Kerja</h2>
            <div class="row mt-5 mb-2">
                <div class="col-6" style="margin-top:-10px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="head bg-secondary-subtle mr-1">Divisi</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6" style="margin-top:-10px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="head bg-secondary-subtle mr-1">Tgl Mulai</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6" style="margin-top:-12px;">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%; padding: 2px; border-width: 1px;" class="head bg-secondary-subtle mr-1">Tgl Cetak</th>
                            <td id="printDate" style="text-align: left;"></td>
                        </tr>
                    </table>
                </div>
            </div>
        <div style="margin-top:-12px;">
            <table class="table-bordered" style="">
                <thead>
                    <tr>
                        <th style="width:8%; padding: 1px;">No. SPK</th>
                        <th style="width:15%; padding: 1px;">Uraian Pekerjaan</th>
                        <th style="width:10%; padding: 1px;">WS</th>
                        <th style="width:10%; padding: 1px;">Mesin</th>
                        <th style="width:10%; padding: 1px;">Jumlah</th>
                        <th style="width:10%; padding: 1px;">Estimasi Menit</th>
                        <th style="width:10%; padding: px;">Ket.</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh Baris 1 -->
                    <?php
                    $repeat = 4;
                    for ($i = 0; $i < $repeat; $i++) {
                    ?>
                    <tr>
                        <td style="text-align: left;" colspan="8" class="section-header">202406083148</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;" colspan="8" class="section-subheader">BARANGNYA</td>
                    </tr>
                    <tr>
                        <td>2021</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                        <tr>
                            <th style="background-color: #e2e3e5;">Operator</th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                        </tr>
                        <tr>
                            <th style="background-color: #e2e3e5;">
                                Tanggal: <br>
                                Mulai: <br>
                                Selesai: <br>
                                Jumlah:
                            </th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                            <th class="border1"></th>
                        </tr>
                        <?php
                        }
                        ?>
                    <!-- Tambah baris tambahan sesuai kebutuhan -->
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
    </div>

    <script>
    // Fungsi untuk menampilkan tanggal saat ini
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        var year = date.getFullYear();
        return day + '/' + month + '/' + year;
    }

    // Menampilkan tanggal cetak di elemen dengan id 'printDate'
    document.getElementById("printDate").innerHTML = formatDate(new Date());
</script>
</body>
</html>
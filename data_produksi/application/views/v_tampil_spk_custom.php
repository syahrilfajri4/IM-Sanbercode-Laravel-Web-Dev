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
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 8px;
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
            font-size: 12px; /* Mengatur ukuran font */
        }
        .table-bordered thead {
            background-color: #e2e3e5; /* Warna biru untuk latar belakang */
            /* color: white; Warna teks putih untuk kontras */
        }
    </style>
</head>
<body>
<!-- <body onload="window.print()" style="font-size:12px;"> -->
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
                            <td></td>
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
                    <tr>
                        <td style="text-align: left;" colspan="8" class="section-header">202406083148</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;" colspan="8" class="section-subheader">Roda 24" ABS</td>
                    </tr>
                    <tr>
                        <td>202100001</td>
                        <td>Proses -</td>
                        <td>Preparasi</td>
                        <td>PR2</td>
                        <td>13 Pcs</td>
                        <td>430</td>
                        <td>pipa</td>
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

                    <!-- Tambah baris tambahan sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
</body>
</html>
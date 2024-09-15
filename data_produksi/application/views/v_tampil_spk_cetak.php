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
        .table1 {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #000;
        }

        .page-break {
        page-break-before: always;
        }

        .border1 {
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid #000;
        }

        th, td {
            text-align: left;
            padding: 3px;
        }


        @media print {
            tr.vendorListHeading {
                background-color: #e2e3e5 !important;
                -webkit-print-color-adjust: exact; 
            }
        }
    </style>
</head>
<body onload="window.print()" style="font-size:12px;">
    <div class="container-fluid">
        <br>
        <h3 `align`="center">SURAT PERINTAH KERJA</h3>
        <br>
        <b>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%;" class="head bg-secondary-subtle mr-1">Seksi Unit Kerja</th>
                            <td><?php echo $head->Divisi ?></td>
                        </tr>
                    </table>
                </div>

                <div class="col">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%;" class="bg-secondary-subtle mr-1">Tanggal Cetak</th>
                            <td><?php echo date('d-m-Y H:i'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row" style="margin-top:-10px;">
                <div class="col">
                    <table class="table table-bordered">
                        <tr class="vendorListHeading">
                            <th style="width:35%;" class="bg-secondary-subtle mr-1">Tanggal SPK</th>
                            <td><?php echo $head->tgl_mulai ?></td>
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
        </b>
        
        <br>

        <!-- HEAD -->
        <table>
            <!-- <thead> -->
            <tr class="vendorListHeading">
                <th class="border1 text-center" rowspan="2" width="5%">Nomor</th>
                <th class="border1 text-center" colspan="4" rowspan="2" width="20%">Uraian Pekerjaan</th>
                <th class="border1 text-center" rowspan="2" width="5%">WS</th>
                <th class="border1 text-center" rowspan="2" width="5%">Mesin</th>
                <th class="border1 text-center" rowspan="2" width="5%">Jumlah</th>
                <th class="border1 text-center" rowspan="2" width="5%">Estimasi (Menit)</th>
                <th class="border1 text-center" width="7%">Tgl Mulai</th>
                <th class="border1 text-center" rowspan="2" width="5%">Ket.</th>
                <tr class="vendorListHeading">
                    <th class="border1 text-center" width="7%">Jam Mulai</th>
                </tr>

            </tr>
            <!-- </thead> -->

            <!-- JUDUL -->
            <!-- <table class="table-borderless" style="border-collapse:collapse; border-spacing:0; margin-top:-10px;">
                <thead> -->
                    <tr>
                        <td colspan="11" style="font-size:11px;"><b><?php echo $head->noref ?> - <?php echo $head->produk ?></b></th>
                    </tr>

                    <tr>
                        <td colspan="11" style="font-size:11px;"><b><?php echo $head->produk ?></b></th>
                    </tr>
                <!-- </thead>
            </table> -->
            
            <?php foreach($cetak as $x): ?>
                <?php $counter = 0; if ($counter % 4 == 0 && $counter > 0): ?>
                    <div class="page-break"></div>
                <?php endif; ?>
                <tr>
                    <th class="border1"><?= $x->spk ?></th>
                    <th class="border1" colspan="4"><?= $x->proses ?> - <?= $x->nabar ?></th>
                    <th class="border1"><?= $x->nama_ws ?></th>
                    <th class="border1"></th>
                    <th class="border1"><?= $x->Jumlah ?> <?= $x->Unit ?></th>
                    <th class="border1"><?= $x->estimasi ?></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                </tr>

                <tr>
                    <th>Operator</th>
                    <th class="border1"><?= isset($operator1->nama_pengguna) ? $operator1->nama_pengguna : 'Belum Dipilih' ?></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                </tr>

                <tr>
                    <th>
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
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                    <th class="border1"></th>
                </tr>
            <?php endforeach; ?>
        </table>
        
        <br>

        <table class="table-borderless">
            <thead>
                <tr>
                    <th width="1800px">Manager / Wakil Produksi</th>
                    <th width="120">
                        Pemberi Tugas<br>
                        Supervisor
                    </th>
                    <th width="120">
                        Diterima,<br>
                        Kepala Seksi
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr><td class="text-white">&nbsp</td></tr>
                <tr><td class="text-white">&nbsp</td></tr>
                <tr>
                    <td><u><b>Hary K.</b></u><b class="text-light"> / </b><u><b>Agus B.</b></u></td>
                    <td><u><b>________________</b></u></td>
                    <td><u><b>________________</b></u></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
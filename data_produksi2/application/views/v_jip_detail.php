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
    
    <title>JIP Detail</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="background-color: #1F497D;">
            <!-- Form Filter -->
            <div class="col-3 mt-4">
                <div class="row">
                    <div class="col"><label style="color:#ffffff;">Ref No</label></div>
                    <div class="col-9"><input type="text" class="form-control" Value="" Readonly></div>  
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col"><label style="color:#ffffff;">Cari</label></div>
                    <div class="col-9"><input type="text" class="form-control"></div>  
                </div>
            </div>
            <div class="col-5 mt-4">
                <div class="row">
                    <div class="col-5"></div>
                    <div class="col-3 d-grid"><button type="button" class="btn btn-primary">Filter</button></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-2"><label style="color:#ffffff;">Status SPK:</label></div>
                    <div class="col-3 d-grid">
                        <select class="form-select" name="" id="">
                            <option value="">Active</option>
                        </select>
                    </div>
                    <div class="col-3 d-grid"><button type="button" class="btn btn-primary">Reset Filter</button></div>
                    <div class="col-4 d-grid"><button type="button" class="btn btn-primary">Cetak Ulang SPK</button></div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="row">
                    <div class="col-6"><label style="color:#ffffff; font-size: 14px;">Jumlah SPK yang belum Ditugaskan</label></div>
                    <div class="col-2 d-grid"><input type="number" class="form-control" value="" Readonly></input></div>
                    <div class="col-4 d-grid"><button type="button" class="btn btn-primary">Tugaskan Semua</button></div>
                </div>
                <div class="row mt-2">
                    <div class="col-2"><label style="color:#ffffff;">No.SPK</label></div>
                    <div class="col-6 d-grid"><input type="text" class="form-control" value="" ></div>
                    <div class="col-4 d-grid">
                        <a href="<?= base_url('c_dashboard/spk_rekap?id_mps=' . $id_mps); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="display table border border-3" style="width: 100%;">
                    <thead  style="background-color = #1F497D;">
                        <tr>
                            <th scope="col">Barcode</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Proses</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Realisasi</th>
                            <th scope="col">Mesin</th>
                            <th scope="col">Operator</th>
                            <th scope="col">Tgl Rencana</th>
                            <th scope="col">Tgl Cetak</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($spk as $spk){ ?> 
                        <tr>
                            <td><?= $spk->Barcode ?></td>
                            <td><?= $spk->Item ?></td>
                            <td><?= $spk->Proses ?></td>
                            <td><?= $spk->Satuan ?></td>
                            <td><?= $spk->Jumlah ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php if($spk->tgl_mulai == "0000-00-00 00:00:00") { ?>
                                <td></td>
                            <?php } else { ?>
                                <td><?= $spk->tgl_mulai ?></td>
                            <?php } ?>
                            <td></td>
                            <td>
                                <div class="btn-group">
                                <?php if($spk->tgl_mulai != "0000-00-00 00:00:00") { ?>
                                    <a class="btn-outline-dark text-white btn btn-secondary  btn-sm" disabled>Tugaskan</a>
                                <?php } else { ?>
                                    <a class="btn-outline-dark text-white btn btn-primary btn-sm" href="<?= site_url().'C_mps/update_spk_divisi?barcode='.$spk->Barcode ?>">Tugaskan</a>
                                <?php } ?>
                                    <a href="<?= site_url().'C_mrp/kustomisasi/?barcode='.$spk->Barcode ?>" target="_blank" class="btn-outline-dark text-white btn btn-primary btn-sm">Lihat</a>
                                    <button class="btn-outline-dark text-white btn btn-primary btn-sm">Generate</button>
                                    <button class="btn-outline-dark text-white btn btn-primary btn-sm">Submit</button>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <body>

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

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>
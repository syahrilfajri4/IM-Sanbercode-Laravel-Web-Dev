<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css') ?>">
    <title>MRP</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="background-color: #1F497D;">
            <div class="col-6 mt-1">
                <label class="text-white">Rencana Produksi:</label>
            </div>
            <div class="col-6 mt-1 text-end">
                <button type="button" class="btn btn-secondary mb-2">Keluar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table id="datatable" class="display table border border-3" style="width: 100%;">
                    <thead style="background-color: #1F497D; color: #fff;">
                        <tr>
                            <th>Ref No</th>
                            <th>Series</th>
                            <th>Kebutuhan</th>
                            <th>Dialokasi</th>
                            <th>WO/PO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($dtl['RefNo']) ?></td>
                            <td><?= htmlspecialchars($dtl['Series']) ?></td>
                            <td><?= htmlspecialchars($dtl['kebutuhan']) ?></td>
                            <td><?= htmlspecialchars($dtl['alokasi']) ?></td>
                            <td><?= htmlspecialchars($dtl['order']) ?></td>
                            <td>
                                <button type="submit" form="form_mrp" class="btn btn-primary">&#9989;</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <form id="form_mrp" action="<?= site_url('c_mrp/input_wopo_alokasi') ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($dtl['id_alokasi']) ?>">
            <input type="hidden" name="idpart" value="<?= htmlspecialchars($dtl['id_part']) ?>"> <!-- Id inventory untuk part -->
            <input type="hidden" name="kanban" value="<?= htmlspecialchars($dtl['kanban']) ?>">
            <input type="hidden" name="Ref" value="<?= htmlspecialchars($dtl['RefNo']) ?>">
            <input type="hidden" name="brg" value="<?= htmlspecialchars($dtl['id_barang']) ?>">
            <input type="hidden" name="periode" value="<?= htmlspecialchars($dtl['periode']) ?>">
            <input type="hidden" name="id_mp" value="<?= htmlspecialchars($dtl['id_mp']) ?>">
            <input type="hidden" name="tahun" value="<?= htmlspecialchars($dtl['tahun']) ?>">

            <!-- Form inputs here -->
            <div class="row mt-2">
                <div class="col-3"><label>Nama Barang</label></div>
                <div class="col-9">
                    <input type="text" name="barang" class="form-control" style="background-color:#e8e8e8;" value="<?= htmlspecialchars($dtl['barang']) ?>" readonly>
                </div>
            </div>
            <!-- Other input fields -->

            <!-- Handle Alokasi input -->
            <div class="row mt-1">
                <?php 
                    $kat = $dtl['kategori'];
                    if ($kat == "Komponen Rehab" || $kat == "Component" || $kat == "Komponen Furniture") {
                ?>
                    <div class="col-6">
                        <label>Alokasi</label>
                    </div>
                    <div class="col-6">
                        <input type="number" max="<?= htmlspecialchars($saldo_alokasi) ?>" name="alokasi" class="form-control">
                    </div>
                <?php
                    } else {
                ?>
                    <div class="col-3">
                        <label>Alokasi</label>
                    </div>
                    <div class="col-9">
                        <input type="number" max="<?= htmlspecialchars($saldo_alokasi) ?>" name="alokasi" class="form-control" <?= $dtl['stok'] < $dtl['kebutuhan'] ? 'readonly placeholder="Stok Tidak Mencukupi Kebutuhan"' : '' ?>>
                    </div>
                <?php
                    }
                ?>
            </div>
            <!-- More form fields -->

            <div class="row mt-1">
                <div class="col">
                    <div class="row mt-1">
                        <?php if ($kat == "Komponen Rehab" || $kat == "Component" || $kat == "Komponen Furniture"): ?>
                            <div class="col-3"><label>Produksi (WO)</label></div>
                            <div class="col-9"><input type="number" name="wo" max="<?= htmlspecialchars($saldo_order) ?>" min="0" class="form-control"></div>
                            <div class="col-3"><label>Keterangan</label></div>
                            <div class="col-9"><textarea name="keterangan" required class="form-control" cols="20" rows="5"></textarea></div>
                        <?php else: ?>
                            <div class="col-6"><label>Pengadaan (PO)</label></div>
                            <div class="col-6"><input type="number" name="po" required max="<?= htmlspecialchars($saldo_order) ?>" min="0" class="form-control"></div>
                            <div class="col-6"><label>Tanggal Dibutuhkan</label></div>
                            <div class="col-6"><input type="date" name="tgl_butuh" required class="form-control"></div>
                            <div class="col-3"><label>Keterangan</label></div>
                            <div class="col-9"><textarea name="keterangan_po" required class="form-control" cols="20" rows="5"></textarea></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript includes -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
            $('select').select2();
        });
    </script>
</body>
</html>

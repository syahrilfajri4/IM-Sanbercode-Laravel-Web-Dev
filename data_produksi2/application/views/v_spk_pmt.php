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
    
    <!-- CSS Kustom -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
    <title>MRP</title>
    <style>
    .navbar-custom {
        background-color: #1F497D;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .btn {
        color: #fff;
    }
    </style>
</head>
<body>
<?php 
    $dtl = $detail->row_array();
    ?>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" style="font-size: 1.5rem;">RENCANA PRODUKSI</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <a href="<?= site_url('c_mrp') ?>" class="btn btn-secondary mb-2" onclick="closeTab()">Kembali</a>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row mt-2">
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

                <!-- form spk pmt -->
                <form id="form_mrp" action="<?= site_url('c_mrp/input_wopo_alokasi') ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($dtl['id_alokasi']); ?>">
                <input type="hidden" name="idpart" value="<?php echo htmlspecialchars($dtl['id_part']); ?>"> <!-- Id inventory untuk part --> 
                <input type="hidden" name="kanban" value="<?php echo htmlspecialchars($dtl['kanban']); ?>">
                <input type="hidden" name="Ref" value="<?php echo htmlspecialchars($dtl['RefNo']); ?>">
                <input type="hidden" name="brg" value="<?php echo htmlspecialchars($dtl['id_barang']); ?>">
                <input type="hidden" name="periode" value="<?php echo htmlspecialchars($dtl['periode']); ?>">
                <input type="hidden" name="id_mp" value="<?php echo htmlspecialchars($dtl['id_mp']); ?>">
                <input type="hidden" name="tahun" value="<?php echo htmlspecialchars($dtl['tahun']); ?>">

                <div class="row mt-2">
                    <div class="col-3"><label>Nama Barang</label></div>
                    <div class="col-6">
                        <input type="text" name="barang" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($dtl['barang']); ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-3"><label>Kategori</label></div>
                    <div class="col-6">
                        <input type="text" name="kategori" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($dtl['kategori']); ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-3"><label>Satuan</label></div>
                    <div class="col-6">
                        <input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($dtl['satuan']); ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-3"><label>Kebutuhan</label></div>
                    <div class="col-6">
                        <input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($dtl['kebutuhan']); ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-3"><label>Total Alokasi</label></div>
                    <div class="col-6">
                        <input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($dtl['alokasi']); ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-3"><label>Total WO/PO</label></div>
                    <div class="col-6">
                        <input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($dtl['order']); ?>" readonly>
                    </div>
                </div>

                <!-- Handle Alokasi input -->
                <div class="row mt-1">
                    <?php 
                        $alokasi1 = $dtl['alokasi'];
                        $stok1 = $dtl['stok'];
                        $total1 = $stok1 - $alokasi1;
                    ?>
                    <div class="col-3"><label>Stok</label></div>
                    <div class="col-6">
                        <input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($total1); ?>" readonly>
                    </div>
                </div>

                <div class="row mt-1">
                    <?php
                        $saldo_alokasi = $dtl['kebutuhan'] - $dtl['alokasi'];
                    ?>
                    <div class="col-3"><label>Saldo Alokasi</label></div>
                    <div class="col-6">
                        <input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?php echo htmlspecialchars($saldo_alokasi); ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col">
                        <div class="row mt-1">
                            <?php
                                $kat = $dtl['kategori'];
                                if ($kat == "Komponen Rehab" || $kat == "Component" || $kat == "Komponen Furniture") {
                            ?>
                                <div class="col-3">
                                    <label>Alokasi</label>
                                </div>
                                <div class="col-6">
                                    <input type="number" max="<?php echo htmlspecialchars($saldo_alokasi); ?>" name="alokasi" class="form-control">
                                </div>
                            <?php
                                } else {
                            ?>
                                <div class="col-3">
                                    <label>Alokasi</label>
                                </div>
                                <div class="col-6">
                                    <input type="number" max="<?php echo htmlspecialchars($saldo_alokasi); ?>" name="alokasi" class="form-control">
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row mt-1">
                        <div class="col-3">
                            <label>Penerima</label>
                        </div>
                        <div class="col-6">
                            <?php
                                // Mengambil data pengguna dari database
                                $user = $this->db->query("SELECT * FROM employee WHERE divisi IN (1, 2, 4, 5, 6, 7, 9, 32, 33, 34, 35, 36, 42) AND status = 2")->result();
                            ?>
                            <select class="form-control select2" name="penerima" id="penerimaSelect">
                                <option disabled selected>PILIH NAMA PENERIMA</option>
                                <?php foreach($user as $value): ?>
                                    <option value="<?php echo $value->ID; ?>"><?php echo $value->ID . ' ' . $value->NAMA; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <?php
                        $saldo_order = $dtl['kebutuhan'] - $dtl['order'];
                    ?>
                    <div class="col-3"><label>Saldo WO/PO</label></div>
                    <div class="col-6"><input type="text" class="form-control" style="background-color:#e8e8e8;" value="<?= htmlspecialchars($saldo_order) ?>" readonly></div>
                </div>

                <?php $kat = $dtl['kategori']; ?>
                <?php if ($kat == "Komponen Rehab" || $kat == "Component" || $kat == "Komponen Furniture"): ?>
                    <div class="row mt-1">
                        <div class="col-3"><label>Produksi (WO)</label></div>
                        <div class="col-6"><input type="number" name="wo" max="<?= htmlspecialchars($saldo_order) ?>" min="0" class="form-control"></div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-3"><label>Keterangan</label></div>
                        <div class="col-6"><input name="keterangan" required class="form-control"></div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col">
                            <div class="row mt-1">
                                <div class="col-6"><label>Pengadaan (PO)</label></div>
                                <div class="col-6"><input type="number" name="po" required max="<?= htmlspecialchars($saldo_order) ?>" min="0" class="form-control"></div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row mt-1">
                                <div class="col-3"><label>Tanggal Dibutuhkan</label></div>
                                <div class="col-3"><input type="date" name="tgl_butuh" required class="form-control"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-3"><label>Keterangan</label></div>
                        <div class="col-6"><input name="keterangan_po" required class="form-control"></div>
                    </div>
                    <br>
                <?php endif; ?>
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

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('#penerimaSelect').select2({
                    placeholder: "PILIH NAMA PENERIMA",
                    allowClear: true
                });
            });
            
            function closeTab() {
                window.close();  // Menutup tab saat ini
            }
        </script>
    </body>
</html>



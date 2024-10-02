<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            
        <!-- Font Awesome -->
        <link href="<?= base_url() . 'assets/fontawesome-free/css/all.min.css' ?>" rel="stylesheet" type="text/css">
            
        <!-- Datatable CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
           
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Select2 Bootstrap 5 Theme CSS -->
        <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
        
        <!-- CSS Kustom -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
            
        <title>MRP</title>

        <style>
            .bg-success {
                background-color: #28a745; /* Hijau */
                color: #ffffff; /* Putih untuk teks */
            }
            .bg-warning {
                background-color: #ffc107; /* Kuning */
                color: #000000; /* Hitam untuk teks */
            }
        </style>

</head>
<body>
<div class="container-fluid">
        <!-- Form Filter -->
        <form action="<?= base_url('c_mrp/filter/') ?>" method="POST" enctype="multipart/form-data">
            <div class="row" style="background-color: #1F497D;">
                <div class="col-4 mt-4">
                    <div class="row">
                        <div class="col">
                            <label style="color:#ffffff;">Nama Barang</label>
                        </div>
                        <div class="col-8"><input type="text" name="nabar" class="form-control"></div>  
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col">
                            <!-- Label untuk kategori -->
                            <label style="color:#ffffff;">Kategori</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" name="kategori" id="Kategori">
                                <?php 
                                // Daftar kategori yang akan ditampilkan dalam dropdown
                                $categories = [
                                    'Komponen Rehab',
                                    'Component',
                                    'Part',
                                    'Fitting',
                                    'Part Import',
                                    'Packing'
                                ];

                                // Loop melalui setiap kategori untuk membuat opsi dalam dropdown
                                foreach ($categories as $category) {
                                    // Tentukan apakah kategori saat ini adalah kategori yang dipilih
                                    $selected = (!empty($cat) && $cat == $category) ? 'selected' : '';
                                    // Tampilkan opsi dropdown dengan kategori dan atribut 'selected' jika cocok
                                    echo "<option value=\"$category\" $selected>$category</option>";
                                }
                                ?>
                            </select>
                        </div>  
                    </div>

                    <!-- dropdown untuk memilih tahun, dan akan menampilkan tahun-tahun yang sesuai dengan kondisi yang diberikan -->
                    <div class="row mt-2">
                        <div class="col">
                            <!-- Label untuk Tahun -->
                            <label style="color:#ffffff;">Tahun</label>
                        </div>
                        <div class="col-8">
                            <?php 
                            $tahun = date('Y'); // Mendapatkan tahun saat ini
                            ?>
                            <select class="form-select" name="tahun" id="">
                                <?php 
                                // Jika $year kosong, tampilkan opsi tahun dari tahun saat ini hingga 4 tahun ke depan
                                if(empty($year)) { 
                                    for($i = $tahun; $i < $tahun + 5; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                } else { 
                                    // Jika $year tidak kosong, tampilkan opsi dengan tahun yang dipilih
                                    echo "<option value=\"$year\" selected>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- dropdown untuk memilih periode atau kuartal -->
                    <div class="row mt-2">
                        <div class="col">
                            <label style="color:#ffffff;">Periode</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" name="periode" id="">
                                <?php 
                                // Menentukan nilai periode yang aktif
                                $active_period = !empty($kuartal) ? $kuartal : $periode;

                                // Loop untuk membuat opsi dropdown
                                for ($i = 1; $i <= 4; $i++) {
                                    $selected = ($i == $active_period) ? 'selected' : '';
                                    echo "<option value=\"$i\" $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>  
                    </div>
                    
                    <!-- Ambil data dari database erp_master_plan_sche dan tabel mrp -->
                    <div class="row mt-2 mb-4">
                        <div class="col"><label style="color:#ffffff;">Nomor Ref</label></div>
                        <div class="col-8">
                            <?php 
                            $referensi = $this->db->query("SELECT * FROM erp_master_plan_sche WHERE `ID MPS` IS NULL GROUP BY `Ref No`")->result_array(); 
                            ?>

                            <select class="form-select" name="ref" id="">
                                <?php if (empty($noref)) { ?>
                                    <option selected value="default" disabled>Pilih Plan</option>
                                    <?php foreach ($referensi as $rf): ?>
                                        <option value="<?= $rf['ID'] ?>"><?= $rf['Ref No'] ?></option>
                                    <?php endforeach; ?>
                                <?php } else { 
                                    $noreferensi = $this->db->query("SELECT RefNo, kanban FROM mrp WHERE kanban = '$noref'")->row(); 
                                    ?>
                                    <option value="<?php echo $noreferensi->kanban ?>"><?php echo $noreferensi->RefNo ?></option>
                                    
                                    <?php 
                                    $no_ref = $this->db->query("SELECT RefNo, kanban FROM mrp WHERE kanban != '$noref' GROUP BY kanban")->result(); 
                                    foreach ($no_ref as $x): ?>
                                        <option value="<?= $x->kanban ?>"><?= $x->RefNo ?></option>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                        </div>  
                    </div>
                </div>

                    <div class="col-3 mt-4">
                        <div class="row mb-2">
                            <div class="col-6 d-grid">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                            <div class="col-6 d-grid">
                                <a href="<?= site_url('c_dashboard') ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 d-grid">
                                <a href="<?= base_url('c_mrp') ?>" class="btn btn-primary">Reset Filter</a>
                            </div>  
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 d-grid">
                                <a href="<?= base_url('c_inventory') ?>" class="btn btn-primary">Stok Gudang</a>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-6 d-grid">
                                <a href="<?= base_url('c_mrp/lihat_pmt') ?>" class="btn btn-warning" target="_blank">Lihat PMT</a>
                            </div>  
                        </div>
                        <div class="row mt-2">
                            <div class="col-6 d-grid">
                                <a href="<?= base_url('c_mrp/lihat_bpb') ?>" class="btn btn-warning" target="_blank">Lihat BPB</a>
                            </div>  
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row mt-2">
            <div class="col">
                <div class="table-wrapper">
                    <table id="datatable" class="display table border border-3 table-hover">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Kebutuhan</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Alokasi</th>
                                <th scope="col">Order</th>
                                <th scope="col">Adjusting</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mrp as $item): ?>
                            <?php
                                $stok1 = $item->stok;
                                $alokasi1 = $item->alokasi;
                                $total = $stok1 - $alokasi1; 
                                $status = empty($item->alokasi) ? 'Belum' : 'Terencana';
                                $statusClass = $status === 'Terencana' ? 'bg-success text-white' : 'bg-warning text-dark'; // Class for background color
                            
                                // Class untuk warna stok berdasarkan kondisi
                                $stokClass = ($total >= $item->kebutuhan) ? 'bg-success text-white' : 'bg-danger text-white';
                            ?>
                            <tr>
                                <td>
                                    <a target="_blank" href="<?= base_url('c_mrp/detail_mrp?kode=' . $item->id_alokasi) ?>" class="btn btn-primary">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($item->kategori) ?></td>
                                <td><?= htmlspecialchars($item->barang) ?></td>
                                <td><?= htmlspecialchars($item->satuan) ?></td>
                                <td><?= htmlspecialchars($item->kebutuhan) ?></td>
                                <td class="<?= $stokClass ?>"><?= htmlspecialchars($total) ?></td> <!-- Stok dengan warna kondisi -->
                                <!-- <?php
                                    $stok1 = $item->stok;
                                    $alokasi1 = $item->alokasi;
                                    $total = $stok1 - $alokasi1; 
                                ?> -->
                                <td style="background-color: yellow;"><?= htmlspecialchars($item->alokasi) ?></td>
                                <td style="background-color: yellow;"><?= htmlspecialchars($item->order) ?></td>
                                <td style="background-color: yellow;">0</td>
                                <td class="<?= $statusClass ?>"><?= htmlspecialchars($status) ?></td> <!-- Menampilkan status dengan warna -->
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    <div class="row">
                                        <div class="col-2">
                                            <label class="mt-2 px-5" style="color: #ffffff;">Alokasi Stock</label>
                                        </div>
                                        <div class="col-3">
                                            <!-- <input type="text" class="form-control" value="<?= $total_order ?>" readonly> -->
                                        </div>
                                        <div class="col-2">
                                            <label class="mt-2 px-5" style="color: #ffffff;">Auto Order</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" value="" readonly>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Modal Heading</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- Tabel untuk stok barang -->
                        <div class="custom-table-wrapper">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Stok Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($inventory) && !empty($inventory)): ?>
                                        <?php foreach ($inventory as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item->Kode) ?></td>
                                            <td><?= htmlspecialchars($item->Item) ?></td>
                                            <td><?= htmlspecialchars($item->Category) ?></td>
                                            <td><?= htmlspecialchars($item->Unit) ?></td>
                                            <td><?= htmlspecialchars($item->stok) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">Data tidak tersedia</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- wajib jquery  -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        
        <!-- Popper.js untuk Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

        <!-- Bootstrap JS Bundle (termasuk Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
        
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    "scrollY": "300px", // Sesuaikan tinggi scroll sesuai kebutuhan Anda
                    "scrollCollapse": true,
                    "paging": false
                });
            });
        </script>
    </body>
</html>
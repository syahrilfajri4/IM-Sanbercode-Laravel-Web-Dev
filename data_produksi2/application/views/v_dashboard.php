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
            
        <!-- Datatable CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
           
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Select2 Bootstrap 5 Theme CSS -->
        <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
        
        <!-- CSS Kustom -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
            
        <title>Dashboard</title>
        <style>
            .select2-container {
                z-index: 1051; /* Pastikan z-index lebih tinggi dari modal (default Bootstrap modal z-index adalah 1050) */
            }
        </style>
</head>
<body>

    <?php if ($this->session->flashdata('success')): ?>
        <script>
            alert('Data Berhasil Disimpan, Silahkan Aktivasi');
        </script>
    <?php endif; ?>

    <div class="container-fluid">
            <div class="row" style="background-color: #1F497D;">
                <!-- Menu/Button Atas -->
                <div class="col mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#JIPmodal">Input JIP</button>
                    <a class="btn btn-primary" href="<?= site_url().'c_mrp' ?>">MRP Assy</a>
                    <a class="btn btn-primary" href="<?= site_url().'C_monitoring_rakit' ?>">Monitor Rakit</a>
                    <a class="btn btn-primary" href="<?= site_url().'C_MonitoringSpk' ?>">Monitor SPK</a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Cetak SPK</button>
                    <a class="btn btn-primary" href="<?= site_url().'C_Bom' ?>">Struktur BOM</a>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#JIPmodal2">Komponen</button> -->
                    
                </div>
                <div class="col mt-4 text-end">
                <label class="date-time" style="color:#ffffff;"><i></i></label>
                    <i><?php
                            // Menampilkan tanggal dan jam saat ini
                            echo '<span id="currentDateTime" style="color:#ffffff;">' . date('d M Y H:i:s') . '</span>';
                        ?>
                    </i>
                    <a href="<?= base_url().'' ?>" type="button" class="btn btn-primary">Log Out</a>
                </div>
            </div>

        <!-- Modal input JIP -->
        <div class="modal fade" id="JIPmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"id="exampleModalLabel">Input JIP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <form action="<?= site_url('c_dashboard/inputJIP') ?>" method="POST">
                        <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-3">Produk</div>
                            <div class="col-9">
                                <!-- tampil barang dan series -->
                                <select class="form-control" name="barang" id="barang">
                                    <option value="">Pilih Produk</option>
                                    <?php foreach($barang as $key => $value): ?>
                                        <option value="<?php echo $value->ID; ?>">
                                            <?php 
                                                // Menampilkan Series jika ada, atau Nama Komponen jika tidak ada Series
                                                echo (!empty($value->Series) ? $value->Series : $value->ItemName) . ' - ' . $value->ItemName;
                                            ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                            <div class="row mt-2">
                                <div class="col-3">Kuantitas</div>
                                <div class="col-9">
                                    <input name="jumlah" id="jumlah" type="number" min="1" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">Periode</div>
                                <div class="col-9">
                                    <select class="form-select" name="periode" id="periode">
                                        <option value=""> Pilih Periode </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal input JIP 2 -->
        <div class="modal fade" id="JIPmodal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"id="exampleModalLabel">Input JIP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                        <form action="<?= site_url('c_dashboard/input_barang') ?>" method="POST">
                        <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-3">Produk</div>
                            <div class="col-9">
                                <!-- tampil barang dan series -->
                                <select class="form-control select2" id="id_barang" name="id_barang" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?php foreach($komponen as $barang): ?>
                                        <option value="<?= $barang->iD ?>"><?= $barang->{'ItemName'} ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                            <div class="row mt-2">
                                <div class="col-3">Kuantitas</div>
                                <div class="col-9">
                                    <input name="jml" id="jml" type="number" min="1" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">Periode</div>
                                <div class="col-9">
                                    <select class="form-select" name="periode1" id="periode1">
                                        <option value=""> Pilih Periode </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal Cetak SPK-->
         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak SPK Divisi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <?php foreach($divisi as $x): ?>
                                <a href="<?= site_url('c_dashboard/tampil_spk_cetak?divisi='.$x->Divisi) ?>" target="_blank" class="list-group-item list-group-item-action">
                                    <?= $x->Divisi ?> &nbsp;&nbsp;<span class="badge text-bg-primary"><?= $x->jumlah_spk ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Filter -->
        <form action="<?= site_url('c_dashboard/filter') ?>" method="POST" enctype="multipart/form-data">
            <div class="row" style="background-color: #1F497D;">
                <div class="col-5 mt-4">
                    <div class="row">
                        <?php
                        $options = [
                            'fg' => 'Finish Goods',
                            'comp' => 'Component',
                        ];

                        if (empty($cat)) {
                            $cat = 'fg';
                        }
                        ?>

                        <div class="col">
                            <label style="color:#ffffff;">Kategori</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" name="kategori" id="kategori">
                                <?php foreach ($options as $value => $label): ?>
                                    <option value="<?= $value; ?>" <?= $cat == $value ? 'selected' : ''; ?>>
                                        <?= $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;">Nomor Ref.</label></div>
                        <div class="col-8"><input type="text" class="form-control"></div>  
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;">Nama Produk</label></div>
                        <div class="col-8"><input type="text" class="form-control"></div>  
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col"><label style="color:#ffffff;">Series</label></div>
                        <div class="col-8"><input type="text" class="form-control"></div>  
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Status</label></div>
                        <div class="col">
                        <select class="form-select" name="stt" id="stt">
                            <?php if ($status == '2' || empty($status)): ?>
                                <option value="2" selected>Active</option>
                                <option value="1">Deactive</option>
                            <?php else: ?>
                                <option value="2">Active</option>
                                <option value="1" selected>Deactive</option>
                            <?php endif; ?>
                        </select>
                        </div>  
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;"></label></div>
                        <div class="col">
                        <select class="form-select" name="stt2" id="stt2">
                            <?php if ($status == '2' || empty($status)): ?>
                                <option value="berjalan" selected>Berjalan</option>
                                <option value="selesai">Selesai</option>
                            <?php else: ?>
                                <option value="berjalan">Berjalan</option>
                                <option value="selesai" selected>Selesai</option>
                            <?php endif; ?>
                        </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;">Tahun</label></div>
                            <div class="col">
                            <select class="form-select" name="tahun" id="tahun">
                                <?php 
                                $tahun = date('Y');
                                
                                if (empty($year)) {
                                    // Jika $year kosong, tampilkan opsi dari tahun sekarang hingga 4 tahun ke depan
                                    for ($i = $tahun; $i < $tahun + 5; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                } else {
                                    // Jika $year ada
                                    if ($year == $tahun) {
                                        // Jika $year sama dengan tahun sekarang
                                        echo "<option value=\"" . ($tahun - 1) . "\">" . ($tahun - 1) . "</option>";
                                        echo "<option selected value=\"$tahun\">$tahun</option>";
                                        for ($i = 1; $i < 5; $i++) {
                                            echo "<option value=\"" . ($tahun + $i) . "\">" . ($tahun + $i) . "</option>";
                                        }
                                    } elseif ($year < $tahun) {
                                        // Jika $year lebih kecil dari tahun sekarang
                                        for ($i = 0; $i < 5; $i++) {
                                            $currentYear = $year + $i;
                                            echo "<option value=\"$currentYear\"" . ($currentYear == $year ? " selected" : "") . ">$currentYear</option>";
                                        }
                                    } elseif ($year > $tahun) {
                                        // Jika $year lebih besar dari tahun sekarang
                                        echo "<option value=\"$year\" selected>$year</option>";
                                        for ($i = 1; $i < 5; $i++) {
                                            echo "<option value=\"" . ($year + $i) . "\">" . ($year + $i) . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                            </div>
                        </div>
                        <?php
                        // Tentukan periode sesuai bulan
                        $bulan = date('n');
                        if ($bulan >= 1 && $bulan <= 3) {
                            $periode1 = 1;
                        } elseif ($bulan >= 4 && $bulan <= 6) {
                            $periode1 = 2;
                        } elseif ($bulan >= 7 && $bulan <= 9) {
                            $periode1 = 3;
                        } else {
                            $periode1 = 4;
                        }

                        // Tentukan kuartal yang dipilih (gunakan kuartal yang ditentukan dari variabel atau default dari periode1)
                        $selected = empty($kuartal) ? $periode1 : $kuartal;
                        ?>

                        <div class="row mt-2">
                            <div class="col">
                                <label style="color:#ffffff;">Periode</label>
                            </div>
                            <div class="col">
                                <select class="form-select" name="periode" id="periode">
                                    <?php
                                    // Loop untuk kuartal 1 sampai 4
                                    for ($i = 1; $i <= 4; $i++):
                                        // Tentukan apakah opsi ini yang terpilih
                                        $selected_attr = ($selected == $i) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $i ?>" <?= $selected_attr ?>> <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 mb-4">
                            <div class="col d-grid">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                            <div class="col d-grid">
                                <a href="<?= base_url().'c_dashboard/' ?>" class="btn btn-primary">Reset Filter</a>
                            </div>  
                        </div>
                    </div>
                <div class="col-4 mt-4">
                    <div class="row">
                        <div class="col-2"><label style="color:#ffffff;">Laporan</label></div>
                        <div class="col-10">
                            <select class="form-select" name="" id="reportSelect">
                                <option value="">Pilih Laporan</option>
                                <option value="<?= base_url('C_monitoring') ?>">Laporan Aktivitas Operator</option>
                                <option value="<?= base_url('c_inventory') ?>">Laporan Stock Gudang</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

                
        <div class="row mt-2">
            <!-- TABLE DAFTAR SPK -->
            <div class="col-lg-7">
                <div class="overflow-auto" style="height:420px;">
                <table id="datatable" class="display table-sm table border border-3" style="width: 100%;">
                    <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center align-middle">Series</th>
                        <th align="center" width="380px" scope="col" class="text-center align-middle">Nama Barang</th>
                        <th align="center" scope="col" class="text-center align-middle">Qty</th>
                        <th align="center" scope="col" class="text-center align-middle">Progress</th>
                        <th scope="col" class="text-center align-middle">No. Referensi</th>
                        <th scope="col" class="text-center align-middle">Status</th>
                        <th scope="col" class="text-center align-middle">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mps as $item): ?>
                        <tr>
                            <td></td>
                            <td><?= isset($item->Barang) ? htmlspecialchars($item->Barang, ENT_QUOTES, 'UTF-8') : 'N/A' ?></td>
                            <td align="center"><?= isset($item->Kuantitas) ? htmlspecialchars($item->Kuantitas, ENT_QUOTES, 'UTF-8') : 'N/A' ?></td>
                            <td align="center">0%</td>
                            <td><?= htmlspecialchars($item->NoRef, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php if ($item->STATUS == 1): ?>
                                    Belum Aktif
                                <?php elseif ($item->STATUS == 2): ?>
                                    Aktif
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td> <!-- Tampilkan status -->
                            <td>
                            <div class="row">
                                <div class="">
                                    <!-- Tombol Aktivasi -->
                                    <?php if ($item->STATUS == 2): ?>
                                        <a href="<?= base_url('c_dashboard/cancel_mps?id_mps=' . urlencode($item->ID)) ?>" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal Aktivasi">
                                            <span><i class="fas fa-power-off"></i></span>
                                        </a>
                                        <a class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Plan sudah aktif">
                                            <span><i class="fas fa-wheelchair"></i></span>
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Belum bisa dibatalkan">
                                            <span><i class="fas fa-power-off"></i></span>
                                        </a>
                                        <a href="<?= base_url('c_dashboard/aktivasi_mps?id_mps=' . urlencode($item->ID)) ?>" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Aktivasi">
                                            <span><i class="fas fa-wheelchair"></i></span>    
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol SPK -->
                                    <?php 
                                    $spk_url = (in_array($item->Category, ['Komponen Rehab', 'Komponen Furniture', 'Component'])) 
                                        ? base_url('c_dashboard/spk_rekap?id_mps=' . urlencode($item->ID)) 
                                        : base_url('c_dashboard/spk_rakit?id_mps=' . urlencode($item->ID));

                                    if ($item->STATUS == 1): ?>
                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Plan Belum Aktif">
                                            <span><i class="fas fa-tools"></i></span>
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= $spk_url ?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Atur Plan">
                                            <span><i class="fas fa-tools"></i></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                </div>
            </div>

                    <!-- TABLE DAFTAR CO -->
                        <div class="col-5">
                            <h6 style="color:#1F497D; ">Informasi Pesanan Pelanggan :</h6>
                            <div class="overflow-auto" style="height:375px;">
                                <table class="display table-sm table table-responsive border border-3" style="width: 100%;">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center align-middle">Series</th>
                                        <th class="text-center align-middle">Nama Barang</th>
                                        <th class="text-center align-middle">Sisa CO</th>
                                        <th class="text-center align-middle">Tersedia</th>
                                        <th class="text-center align-middle">Renass</th>
                                        <th class="text-center align-middle">Batas Waktu</th>
                                        <th class="text-center align-middle">Sisa Hari</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php
                                        foreach($co as $co){
                                        ?> 
                                        <?php
                                            $deadline_date = new DateTime($co->deadline);
                                            $current_date = new DateTime();
                                            $interval = $current_date->diff($deadline_date);
                                            $days_left = $interval->format('%r%a');  // Format %r%a untuk menghitung sisa hari, termasuk tanda negatif

                                            // Cek jika deadline sudah lewat atau sama dengan hari ini
                                            $is_deadline_passed = $deadline_date < $current_date;
                                            $is_deadline_today = $deadline_date->format('Y-m-d') == $current_date->format('Y-m-d');
                                            ?>
                                        <tr>
                                            <td><?= $co->series ?></td>
                                            <td><?= $co->barang ?></td>
                                            <td><?= $co->sisa ?></td>
                                            <td><?= $co->stok ?></td>
                                            <td>0</td>
                                            <td class="<?= ($is_deadline_passed && !$is_deadline_today) ? : '' ?>">
                                                <?= $co->deadline ?>
                                            </td>
                                            <td class="<?= ($is_deadline_passed && !$is_deadline_today) ? 'bg-warning' : '' ?>">
                                                <?= $days_left ?> hari
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

    <!-- wajib jquery  -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script> -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
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
    <script>
        $(document).ready(function() {
            $('#JIPmodal').on('shown.bs.modal', function () {
                $('body').addClass('modal-open');
                $('#barang').select2({
                dropdownParent: $('#JIPmodal')
                });
            });
        });

    // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

            document.getElementById('reportSelect').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                window.location.href = selectedValue;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</footer>
</html>
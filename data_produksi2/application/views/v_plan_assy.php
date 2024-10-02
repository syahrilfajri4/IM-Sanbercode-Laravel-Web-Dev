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

    <title>Plan Assy</title>
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
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" style="font-size: 1.5rem;">RENCANA PERAKITAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= site_url('c_dashboard') ?>" class="btn btn-secondary mb-2">Kembali</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid ml-3">
        <div class="row">
            <div class="col-4 mt-3">
            <?php if (isset($plan_details) && is_object($plan_details)): ?>
            <div class="row">
                <div class="col-3">
                    <label>Ref No</label>
                </div>
                <div class="col-9 d-grid">
                    <input type="text" class="form-control" readonly value="<?= htmlspecialchars($plan_details->RefNo, ENT_QUOTES, 'UTF-8') ?>">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <label>Series</label>
                </div>
                <div class="col-9 d-grid">
                    <input type="text" class="form-control" readonly value="<?= htmlspecialchars($plan_details->Series, ENT_QUOTES, 'UTF-8') ?>">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <label>Produk</label>
                </div>
                <div class="col-9 d-grid">
                    <input type="text" class="form-control" readonly value="<?= htmlspecialchars($plan_details->ItemName, ENT_QUOTES, 'UTF-8') ?>">
                </div>
            </div>

                <!-- <div class="row">
                    <div class="col-3">
                        <label>Ref No</label>
                    </div>
                    <div class="col-9 d-grid">
                    <?php if ($top !== null): ?>
                        <input class="form-control" type="text" value="<?php echo $top->ref_no ?>" disabled>
                    <?php else: ?>
                        <input class="form-control" type="text" value="Data tidak tersedia" disabled>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <label>Series</label>
                    </div>
                    <div class="col-9 d-grid">
                        <input class="form-control" type="text" value="<?php echo $top->series ?>" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <label>Produk</label>
                    </div>
                    <div class="col-9 d-grid">
                        <input class="form-control" type="text" value="<?php echo $top->nama_produk ?>" disabled>
                    </div>
                </div> -->
            </div>
            <!-- <div class="col-4 mt-2">
                <div class="row">
                    <div class="col-4">
                        <label>Satuan</label>
                    </div>
                    <div class="col-8 d-grid">
                        <input class="form-control" type="text" value="<?php echo $top->satuan ?>" disabled>
                    </div>
                </div>
            </div> -->
            <div class="col-4 mt-3">
                <!-- <div class="row">
                    <div class="col-4">
                        <label>Jumlah RenPro</label>
                    </div>
                    <div class="col-8 d-grid">
                        <input class="form-control" type="text" value="<?php echo $top->jumlah_plan ?>" disabled>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-4">
                        <label>Jumlah RenPro</label>
                    </div>
                    <div class="col-8 d-grid">
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($plan_details->PlanQty, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <label>Direncanakan</label>
                    </div>
                    <div class="col-8 d-grid">
                        <input class="form-control" type="text" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <label>Dikompon</label>
                    </div>
                    <div class="col-8 d-grid">
                        <input class="form-control" type="text" disabled>
                    </div>
                </div>
                <?php else: ?>
                    <p style="color:#ff0000;">Plan details not found or invalid ID.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <hr>
        <div class="row mx-2">
        <label for=""><b>Detail Rencana Rakit :</b></label>
        <div class="overflow-scroll" style="height:290px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-11">
                        <table class="table table-bordered table-sm text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nomor SPK</th>
                                    <th scope="col">Tgl Mulai Rakit</th>
                                    <th scope="col">Operator</th>
                                    <th scope="col">Kuantitas</th>
                                    <th class="text-center" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($assy as $r) { ?>
                                    <?php if($r->tahap == 418) { ?>
                                        <tr>
                                            <td style="width:10%;"><?= $r->spk ?></td>
                                            <td style="width:20%;"><?= $r->tanggal_tugas ?></td>
                                            <td style="width:30%;"><?= $r->nama_operator ?></td>
                                            <td style="width:10%;"><?= $r->jml ?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="btn-group">
                                                        <button class="btn btn-white">Aktif</button>
                                                        <a href="#" class="btn btn-outline-dark"><i class="fas fa-check"></i></a>
                                                        <a href="#" class="btn btn-success">BPB</a>
                                                        <button class="btn btn-danger" disabled>CETAK</button>
                                                        <button class="btn btn-primary" data-id="<?= htmlspecialchars($r->ID, ENT_QUOTES, 'UTF-8') ?>">Hapus</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- FORM INPUT SPK ASSY -->
                        <form action="<?= site_url('c_dashboard/input_spk_rakit/'.$mps) ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm text-center">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td><input required type="date" name="tgl_tugas" class="form-control"></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <?php 
                                                            $op = $this->db->query("SELECT ID, NAMA FROM employee WHERE DIVISI IN (1, 2, 4, 5, 6, 7, 9, 32, 33, 34, 35, 36, 42) AND `Status` = 2 ORDER BY NAMA ASC")->result(); 
                                                            ?>
                                                            <select required name="operator1" class="form-select select2" id="operator1">
                                                                <option selected disabled>Operator Rakit</option>
                                                                <?php foreach($op as $x): ?>
                                                                    <option value="<?= $x->ID ?>"><?= $x->NAMA ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <select required name="operator2" class="form-select select2" id="operator2">
                                                                <option disabled selected>Operator Kompon</option>
                                                                <?php foreach($op as $x): ?>
                                                                    <option value="<?= $x->ID ?>"><?= $x->NAMA ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="number" name="jumlah" required class="form-control" min="0"></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="btn-group">
                                                            <button class="btn btn-white">Aktif</button>
                                                            <a href="#" class="btn btn-outline-dark"><i class="fas fa-check"></i></a>
                                                            <a href="#" class="btn btn-success">BPB</a>
                                                            <button class="btn btn-outline-dark" type="submit">BUAT</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mx-2">
        <label for=""><b>Detail Rencana Kompon :</b></label>
        <div class="overflow-scroll" style="height:290px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-11">
                        <table class="table table-bordered table-sm text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nomor SPK</th>
                                    <th scope="col">Tgl SPK</th>
                                    <th scope="col">Operator</th>
                                    <th scope="col">Kuantitas</th>
                                    <th class="text-center" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($assy as $r) { ?>
                                    <?php if($r->tahap == 419) { ?>
                                        <tr>
                                            <td style="width:10%;"><?= $r->spk ?></td>
                                            <td style="width:20%;"><?= $r->tanggal_tugas ?></td>
                                            <td style="width:30%;"><?= $r->nama_operator ?></td>
                                            <td style="width:10%;"><?= $r->jml ?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="btn-group">
                                                        <button class="btn btn-white">Aktif</button>
                                                        <a href="#" class="btn btn-outline-dark"><i class="fas fa-check"></i></a>
                                                        <a href="#" class="btn btn-success">BPB</a>
                                                        <button class="btn btn-danger" disabled>CETAK</button>
                                                        <button class="btn btn-primary">Hapus</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    <!-- Tambahkan event listener di tombol hapus -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-primary').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        const id = this.getAttribute('data-id'); // Ambil ID dari atribut data-id tombol

                        fetch(`/c_dashboard/deleteItem/${id}`, { // Ganti URL dengan rute penghapusan yang sesuai
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ id })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Data berhasil dihapus');
                                // Hapus baris dari tabel setelah penghapusan berhasil
                                this.closest('tr').remove();
                            } else {
                                alert('Gagal menghapus data');
                            }
                        })
                        .catch(error => {
                            console.error('Terjadi kesalahan:', error);
                            alert('Terjadi kesalahan');
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            // Inisialisasi Select2 untuk semua elemen select dengan kelas select2
            $('.select2').select2({
                placeholder: "Pilih Operator", // Placeholder umum
                allowClear: true // Menambahkan tombol clear
            });
        });
    </script>



    </body>
</html>
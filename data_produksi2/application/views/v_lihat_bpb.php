<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?= base_url() . 'assets/fontawesome-free/css/all.min.css' ?>" rel="stylesheet" type="text/css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">
    
    <title>BPB</title>
    <style>
    .navbar-custom {
        background-color: #1F497D;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .btn {
        color: #fff;
    }

    .form-control-sm {
            width: 100px;
        }
        .input-group {
            display: flex;
            align-items: center;
        }
        .input-group .form-control-sm {
            margin-right: 5px; /* Space between input and button */
        }
        .input-group .btn {
            margin-bottom: 0; /* Align button with input */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" style="font-size: 1.5rem;">ALOKASI BARANG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="<?= site_url('c_mrp') ?>" class="btn btn-secondary mb-2" onclick="closeTab()">Kembali</a>
            </div>
        </div>
    </nav>
    <br>
    <div class="container-fluid">        
        <div class="col-sm-4">
                <h4>
                    <strong>Periksa Lagi Barang Yang Mau Di Minta!</strong>
                </h4> 
            <a href="<?= site_url().'c_mrp/insert_bpb' ?>" type="submit" class="my-4 mx-3 col-md-3 d-grid btn btn-primary" style="margin-left:10px">SUBMIT</a>
        </div>
        <form id="spkForm" action="<?= site_url('c_mrp/update_nomor_spk') ?>" method="post">
            <table class="table table-hover table-striped table-bordered">
                <thead class="text-center">
                    <th>No</th>
                    <th>No Referensi</th>
                    <th>ID Fina</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Kategori</th>
                    <th>Nomor SPK</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </thead>

                <tbody>
                    <?php foreach($bpb as $x): ?>
                        <tr>
                            <td><?= $x->id ?></td>
                            <td><?= $x->noref ?></td>
                            <td><?= $x->id_fina ?></td>
                            <td><?= $x->nabar ?></td>
                            <td><?= $x->jumlah ?></td>
                            <td><?= $x->Unit ?></td>
                            <td><?= $x->kat ?></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="nomor_spk[<?= $x->id ?>]" value="<?= htmlspecialchars($x->nomor_spk, ENT_QUOTES, 'UTF-8') ?>" class="form-control form-control-sm" style="width: 65px;">
                                    <button type="button" class="btn btn-primary btn-sm save-btn fas fa-save" data-id="<?= $x->id ?>"></button>
                                </div>
                            </td>
                            <td><?= $x->keterangan ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('c_mrp/hapus/'.$x->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
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

    <script>
        $(document).ready(function () {
            // Event listener for save buttons
            $('.save-btn').on('click', function () {
                var id = $(this).data('id');
                var nomorSpk = $('input[name="nomor_spk[' + id + ']"]').val();

                // Send AJAX request to update SPK
                $.ajax({
                    url: '<?= site_url('c_mrp/update_nomor_spk') ?>',
                    type: 'POST',
                    data: { id: id, nomor_spk: nomorSpk },
                    success: function (response) {
                        alert('Nomor SPK berhasil diperbarui!');
                    },
                    error: function () {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });

        function closeTab() {
            window.close();  // Menutup tab saat ini
        }
    </script>
</body>
</html>
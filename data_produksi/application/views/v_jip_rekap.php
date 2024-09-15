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

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <title>JIP REKAP</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="background-color: #1F497D;">
            <!-- Form Filter -->
            <div class="col-5 mt-4">
                <!-- Memastikan $item didefinisikan -->
                <?php if (isset($item)): ?>
                    <div class="row">
                        <div class="col">
                            <label style="color:#ffffff;">Nomor Referensi</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" readonly value="<?= htmlspecialchars($item->RefNo, ENT_QUOTES, 'UTF-8') ?>">
                        </div>  
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col">
                            <label style="color:#ffffff;">Item</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" readonly value="<?= htmlspecialchars($item->ItemName, ENT_QUOTES, 'UTF-8') ?>">
                        </div>  
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label style="color:#ffffff;">Jumlah</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" readonly value="<?= htmlspecialchars($item->PlanQty, ENT_QUOTES, 'UTF-8') ?>">
                        </div>  
                    </div>
                <?php else: ?>
                    <!-- Tampilkan pesan jika $item tidak tersedia -->
                    <p>Item tidak ditemukan.</p>
                <?php endif; ?>
            </div>
            <div class="col-3 mt-4">
                <div class="row mb-2">
                    <!-- Tombol PMT -->
                    <div class="col-4 d-grid">
                        <a href="<?php echo base_url().'c_dashboard/PMT?id_mps='.$mps; ?>" class="btn btn-primary">PMT</a>
                    </div>
                    
                    <!-- Tombol Custom -->
                    <div class="col-4 d-grid">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Custom</button>
                    </div>
                    
                    <!-- Tombol Kembali -->
                    <div class="col-4 d-grid">
                        <a href="<?php echo base_url().'c_dashboard/filter'; ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form SPK Custom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-9"><b>TAMBAHKAN SPK :</b></div>
                        <div class="row mt-2">
                            <div class="col-3">ID Komponen</div>
                            <div class="col-9">
                                <select class="form-select select2" name="komponen" id="komponen1">
                                    <option value="">Pilih Barang</option>
                                    <?php if (isset($produksi_inventory) && !empty($produksi_inventory)): ?>
                                        <?php foreach ($produksi_inventory as $item): ?>
                                            <option value="<?= htmlspecialchars($item->iD, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?= htmlspecialchars($item->iD . ' ' . $item->{'Item Name'}, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="">Data barang tidak tersedia</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">Pekerjaan</div>
                            <div class="col-9">
                                <select class="form-select select2" name="pekerjaan" id="pekerjaan">
                                        <option value="">Pilih Pekerjaan</option>
                                        <?php if (isset($tahap_produksi) && !empty($tahap_produksi)): ?>
                                            <?php foreach ($tahap_produksi as $item): ?>
                                                <option value="<?= htmlspecialchars($item->ID, ENT_QUOTES, 'UTF-8'); ?>">
                                                    <?= htmlspecialchars($item->ID . ' ' . $item->{'NAMA PROSES'}, ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data barang tidak tersedia</option>
                                        <?php endif; ?>
                                    </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">Jumlah</div>
                            <div class="col-9">
                                <input name="jumlah" id="jumlah" type="number" min="1" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- Ubah baris di bawah untuk menempatkan tombol di ujung kanan -->
                        <div class="row mt-2">
                            <div class="col text-end">
                                <button type="button" class="btn btn-primary" onclick="window.open('<?= base_url('c_dashboard/cetak_spk_custom'); ?>', '_blank')">Cetak Form</button>
                            </div>
                        </div>
                        <hr>
                        <form action="<?= base_url('c_dashboard/simpan_data'); ?>" method="post">
                            <div class="col-9"><b>CETAK FORM KOSONG CUSTOM :</b></div>
                            <div class="row mt-2">
                                <div class="col-3">Nomor SPK</div>
                                <div class="col-9">
                                    <input name="nomorspk" id="nomorspk" type="number" min="1" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">Divisi</div>
                                <div class="col-9">
                                    <select class="form-control select2" name="divisi" id="divisi">
                                        <option disabled selected>Pilih Divisi</option>
                                        <?php foreach($divisi_produksi as $value): ?>
                                            <option value="<?php echo $value->ID; ?>"><?php echo $value->ID . ' - ' . $value->{'Nama Divisi'}; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">Operator</div>
                                <div class="col-9">
                                    <select class="form-select select2" name="operator" id="operator">
                                        <option value="0"> Pilih Operator </option>
                                        <?php foreach($operator_produksi as $key => $value):?>
                                            <option value="<?php echo $value->ID; ?>"><?php echo $value->ID . ' ' . $value->NAMA; ?></option>
                                        <?php endforeach ?>
                                    </select>                         
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">Pekerjaan</div>
                                <div class="col-9">
                                    <select class="form-select select2" name="pekerjaan2" id="pekerjaan2">
                                        <option value="">Pilih Pekerjaan</option>
                                        <?php if (isset($tahap_produksi) && !empty($tahap_produksi)): ?>
                                            <?php foreach ($tahap_produksi as $item): ?>
                                                <option value="<?= htmlspecialchars($item->ID, ENT_QUOTES, 'UTF-8'); ?>">
                                                    <?= htmlspecialchars($item->ID . ' ' . $item->{'NAMA PROSES'}, ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data barang tidak tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">ID Komponen</div>
                                <div class="col-9">
                                    <select class="form-select select2" name="komponen2" id="komponen2">
                                        <option value="">Pilih Barang</option>
                                        <?php if (isset($produksi_inventory) && !empty($produksi_inventory)): ?>
                                            <?php foreach ($produksi_inventory as $item): ?>
                                                <option value="<?= htmlspecialchars($item->iD, ENT_QUOTES, 'UTF-8'); ?>">
                                                    <?= htmlspecialchars($item->iD . ' ' . $item->{'Item Name'}, ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data barang tidak tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-primary">Simpan dan Cetak</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col">
                <table id="datatable" class="display table border border-3" style="width: 100%;">
                    <thead style="background-color:#1F497D;">
                        <tr>
                            <th scope="col">Divisi</th>
                            <th scope="col">Jumlah SPK</th>
                            <th scope="col">Persentase</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <?php
                    $ass_hos = 0;
                    $ass_reh = 0;
                    $ep_ = 0;
                    $ga_ = 0;
                    $m_shop_ = 0;
                    $mms_ = 0;
                    $pc_ = 0;
                    $poles_ = 0;
                    $rik_ = 0;
                    $prep = 0;
                    $weld = 0;
                    $lain = 0;
                    $vynil = 0;

                    foreach ($rekap as $item) {
                        switch ($item->divisi) {
                            case "Assembling Hospital":
                                $ass_hos++;
                                break;
                            case "Assembling Rehab":
                                $ass_reh++;
                                break;
                            case "EP":
                                $ep_++;
                                break;
                            case "GA":
                                $ga_++;
                                break;
                            case "M Shop":
                                $m_shop_++;
                                break;
                            case "MMS":
                                $mms_++;
                                break;
                            case "Vynil":
                                $vynil++;
                                break;
                            case "PC":
                                $pc_++;
                                break;
                            case "Poles":
                                $poles_++;
                                break;
                            case "RIK":
                                $rik_++;
                                break;
                            case "Preparasi":
                                $prep++;
                                break;
                            case "Welding":
                                $weld++;
                                break;
                            default:
                                $lain++;
                                break;
                        }
                    }

                    $divisions = [
                        'Assembling Hospital' => ['count' => $ass_hos, 'link' => 'ass_hos'],
                        'Assembling Rehab' => ['count' => $ass_reh, 'link' => 'ass_reh'],
                        'EP' => ['count' => $ep_, 'link' => 'ep'],
                        'GA' => ['count' => $ga_, 'link' => 'ga'],
                        'M SHOP' => ['count' => $m_shop_, 'link' => 'm_shop'],
                        'MMS' => ['count' => $mms_, 'link' => 'mms'],
                        'PC' => ['count' => $pc_, 'link' => 'pc'],
                        'Poles' => ['count' => $poles_, 'link' => 'poles'],
                        'RIK' => ['count' => $rik_, 'link' => 'rik'],
                        'Preparasi' => ['count' => $prep, 'link' => 'prep'],
                        'Vynil' => ['count' => $vynil, 'link' => 'vynil'],
                        'Welding' => ['count' => $weld, 'link' => 'weld'],
                        'Lain-Lain' => ['count' => $lain, 'link' => 'lain']
                    ];

                    $total_spk = $ass_hos + $ass_reh + $ep_ + $ga_ + $m_shop_ + $mms_ + $pc_ + $poles_ + $rik_ + $prep + $weld + $lain + $vynil;
                    ?>

                    <tbody>
                        <?php foreach ($divisions as $name => $data): ?>
                            <?php if ($data['count'] != 0): ?>
                                <tr>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $data['count']; ?></td>
                                    <td><?php echo ($total_spk > 0) ? round(($data['count'] / $total_spk) * 100, 2) . '%' : '0%'; ?></td>
                                    <td>
                                        <a href="<?php echo base_url() . 'c_dashboard/' . $data['link'] . '?id_mps=' . urlencode($mps); ?>" class="btn btn-primary btn-sm fas fa-location-arrow"></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $('#exampleModal').on('shown.bs.modal', function () {
                $('body').addClass('modal-open');
                $('#komponen1').select2({
                dropdownParent: $('#exampleModal')
                });
                $('#pekerjaan').select2({
                dropdownParent: $('#exampleModal')
                });
                $('#pekerjaan2').select2({
                dropdownParent: $('#exampleModal')
                });
                $('#komponen2').select2({
                dropdownParent: $('#exampleModal')
                });
                $('#operator').select2({
                dropdownParent: $('#exampleModal')
                });
                $('#divisi').select2({
                dropdownParent: $('#exampleModal')
                });
            });
    </script>

</body>
</html>
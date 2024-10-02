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
            
        <title>Beranda</title>
</head>
<body>

    <?php if ($this->session->flashdata('success')): ?>
        <script>
            alert('<?php echo htmlspecialchars($this->session->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?>');
        </script>
    <?php endif; ?>

    <div class="container-fluid">
            <div class="row" style="background-color: #1F497D;">
                <!-- Menu/Button Atas -->
                <div class="col mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#JIPmodal">Input JIP</button>
                    <a class="btn btn-primary" href="<?= site_url().'' ?>">MRP Assy</a>
                    <a class="btn btn-primary" href="<?= site_url().'' ?>">Monitoring</a>
                    <button type="button" class="btn btn-primary">Daftar SPK</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Cetak SPK</button>
                    <button type="button" class="btn btn-primary" >Struktur BOM</button>
                </div>
                <div class="col mt-4 text-end">
                    <a href="<?= base_url().'' ?>" type="button" class="btn btn-primary">Log Out</a>
                </div>
            </div>

    <!-- Form Filter -->
    <form action="<?= site_url('C_mps/filter') ?>" method="POST" enctype="multipart/form-data">
            <div class="row" style="background-color: #1F497D;">
                <div class="col-5 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Kategori</label></div>
                        <div class="col-8">
                            <?php if($cat == 'fg' || empty($cat)) { ?>
                                <select class="form-select" name="kategori" id="kategori">
                                    <option value="fg" selected>Finish Goods</option>
                                    <option value="comp">Component</option>
                                    <option value="cst">Custom</option>
                                    <option value="rwk">Rework</option>
                                </select>
                            <?php } else if($cat == 'comp') { ?>
                                <select class="form-select" name="kategori" id="kategori">
                                    <option value="comp" selected>Component</option>
                                    <option value="fg">Finish Goods</option>
                                    <option value="cst">Custom</option>
                                    <option value="rwk">Rework</option>
                                </select>
                            <?php } else if($cat == 'cst') { ?>
                                <select class="form-select" name="kategori" id="kategori">
                                    <option value="cst" selected>Custom</option>
                                    <option value="fg">Finish Goods</option>
                                    <option value="comp">Component</option>
                                    <option value="rwk">Rework</option>
                                </select>
                            <?php } else if($cat == 'rwk') { ?>
                                <select class="form-select" name="kategori" id="kategori">
                                    <option value="rwk" selected>Rework</option>
                                    <option value="fg">Finish Goods</option>
                                    <option value="comp">Component</option>
                                    <option value="cst">Custom</option>
                                </select>
                            <?php } ?>
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
                                <?php if($status == '2' || empty($status)) { ?>        
                                    <option value="2" selected>Active</option>
                                    <option value="1">Deactive</option>
                                <?php } else { ?>
                                    <option value="2">Active</option>
                                    <option value="1" selected>Deactive</option>
                                <?php } ?>
                            </select>

                        </div>  
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;"></label></div>
                        <div class="col">
                            <select class="form-select" name="stt2" id="">
                                <?php if($status == '2' || empty($status)) { ?>
                                    <option value="">Berjalan</option>
                                    <option value="">Selesai</option>
                                <?php } else { ?>
                                    <option value="">Berjalan</option>
                                    <option value="">Selesai</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;">Tahun</label></div>
                        <div class="col">
                            <select class="form-select" name="tahun" id="">
                                <?php $tahun = DATE('Y') ?>
                                <?php if(empty($year)){ ?>
                                    <?php for($i = $tahun; $i < $tahun + 5 ; $i++)
                                    {
                                        echo "<option value=$i>$i</option>";
                                    } ?>
                                    <option value="<?php echo $tahun - 1?>"><?php echo $tahun - 1?></option>
                                <?php } elseif($year == $tahun) { ?>
                                    <option value="<?php echo $tahun - 1?>"><?php echo $tahun - 1?></option>
                                    <option selected value="<?php echo $year ?>"><?php echo $year ?></option>
                                    <option value="<?php echo $year + 1 ?>"><?php echo $year + 1 ?></option>
                                    <option value="<?php echo $year + 2 ?>"><?php echo $year + 2 ?></option>
                                    <option value="<?php echo $year + 3 ?>"><?php echo $year + 3 ?></option>
                                    <option value="<?php echo $year + 4 ?>"><?php echo $year + 4 ?></option>
                                <?php } elseif($year < $tahun) { ?>
                                    <option value="<?php echo $year ?>"><?php echo $year ?></option>
                                    <option value="<?php echo $year + 1 ?>"><?php echo $year + 1 ?></option>
                                    <option value="<?php echo $year + 2 ?>"><?php echo $year + 2 ?></option>
                                    <option value="<?php echo $year + 3 ?>"><?php echo $year + 3 ?></option>
                                    <option value="<?php echo $year + 4 ?>"><?php echo $year + 4 ?></option>
                                <?php } elseif($year > $tahun) { ?>
                                    <option value="<?php echo $year ?>"><?php echo $year ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><label style="color:#ffffff;">Periode</label></div>
                        <div class="col">
                            <select class="form-select" name="periode" id="">
                                <?php if(empty($kuartal)){ ?>
                                    <?php if($periode == 1) { ?>
                                        <option selected value="<?php echo $periode; ?>"><?php echo $periode; ?></option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    <?php }elseif($periode == 2) { ?>
                                        <option value="1">1</option>
                                        <option selected value="<?php echo $periode; ?>"><?php echo $periode; ?></option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    <?php }elseif($periode == 3) { ?>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option selected value="<?php echo $periode; ?>"><?php echo $periode; ?></option>
                                        <option value="4">4</option>
                                    <?php }elseif($periode == 4) { ?>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option selected value="<?php echo $periode; ?>"><?php echo $periode; ?></option>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if($kuartal == 1) { ?>
                                        <option selected value="<?php echo $kuartal; ?>"><?php echo $kuartal; ?></option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    <?php }elseif($kuartal == 2) { ?>
                                        <option value="1">1</option>
                                        <option selected value="<?php echo $kuartal; ?>"><?php echo $kuartal; ?></option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    <?php }elseif($kuartal == 3) { ?>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option selected value="<?php echo $kuartal; ?>"><?php echo $kuartal; ?></option>
                                        <option value="4">4</option>
                                    <?php }elseif($kuartal == 4) { ?>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option selected value="<?php echo $kuartal; ?>"><?php echo $kuartal; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col d-grid"><button type="submit" class="btn btn-primary">Filter</button></div>
                        <div class="col d-grid"><a type="reset" href="<?= base_url().'C_mps/' ?>" class="btn btn-primary">Reset Filter</a></div>  
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="row">
                        <div class="col-2"><label style="color:#ffffff;">Laporan</label></div>
                        <div class="col-10">
                            <select class="form-select" name="" id="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
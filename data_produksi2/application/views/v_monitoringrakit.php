<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <!--Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>    <!--Datatables 1.13.4-->
    <!--<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>-->
    <!--Datatable 1.10.20-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="<?= site_url().'assets/fontawesome/css/all.min.css' ?>">

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
                <a class="btn btn-primary" href="<?= site_url().'C_mrp' ?>">MRP Assy</a>
                <a class="btn btn-primary" href="<?= site_url().'C_monitoring' ?>">Monitoring</a>
                <button type="button" class="btn btn-primary">Daftar SPK</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Cetak SPK</button>
                <!-- <p><?php //echo $status ?></p> -->
            </div>
            <div class="col mt-4">
                <a href="<?= base_url().'C_login/logout' ?>" type="button" class="btn btn-primary">Log Out</a>
            </div>
        </div>

        <!-- Modal Cetak SPK-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak SPK</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Form Filter -->
        <form action="<?= site_url('C_mps/filter') ?>" method="POST" enctype="multipart/form-data">
            <div class="row" style="background-color: #1F497D;">
                <div class="col-5 mt-4">
                    <div class="row">
                        <div class="col"><label style="color:#ffffff;">Nomor Ref.</label></div>
                        <div class="col-8"><input type="text" class="form-control"></div>  
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col"><label style="color:#ffffff;">Series</label></div>
                        <div class="col-8"><input type="text" class="form-control"></div>  
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="row">
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
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col d-grid"><button type="submit" class="btn btn-primary">Filter</button></div>
                        <div class="col d-grid"><a type="reset" href="<?= base_url().'C_mps/' ?>" class="btn btn-primary">Reset Filter</a></div>  
                    </div>
                </div>
                
            </div>
        </form>
        <div class="row mt-2 mb-4">
                        <div class="col-2 d-grid"><button type="submit" class="btn btn-primary">Perakitan</button></div>
                        <div class="col-2 d-grid"><a type="reset" href="<?= base_url().'C_mps/' ?>" class="btn btn-primary">Lini Proses</a></div>  
        </div>
        <div class="row">
            <!-- TABLE DAFTAR SPK -->
            <div class="col-10">
                <div class="overflow-auto" style="height:420px;">
                    <table id="datatable" class="display table-sm table border border-3" style="width: 100%;">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">NO RenPro</th>
                                <th align="center" width="400px" scope="col">Nama Barang</th>
                                <th align="center" scope="col">Rencana</th>
                                <th align="center" scope="col">Rakit</th>
                                <th align="center" scope="col">Masuk</th>
                                <th scope="col">Mulai Rakit</th>
                                <th scope="col">Update</th>
                                <th>Rakit %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($plan as $plan){
                            ?>
                            <tr>
                                <td><?= $plan->ref ?></td>
                                <td><?= $plan->series ?>-<?= $plan->barang ?></td>
                                <td><?= $plan->plan_qty ?></td>
                                <td><?= $plan->spk_rakit ?></td>
                                <td>kosong</td>
                                <td>kosong</td>
                                <td>kosong</td>
                                <td>0</td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
<footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</footer>
</html>
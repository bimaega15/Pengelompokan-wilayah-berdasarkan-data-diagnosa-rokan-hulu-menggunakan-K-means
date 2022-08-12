<?php $profile = check_profile(); ?>
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $title; ?></h4>

                    <div class="page-title-right">
                        <?= $breadcrumbs; ?>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-calculator"></i> Perhitungan
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Admin/Perhitungan') ?>" method="get">
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="jumlah_cluster" placeholder="Jumlah cluster" value="<?= $jumlah_cluster; ?>">
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                if ($jumlah_cluster != null) :
                    $arr_dataset = $kmeans['arr_dataset'];

                    $headerDataset = [];
                    foreach ($arr_dataset as $key => $v_dataset) {
                        $headerDataset = $v_dataset;
                        break;
                    }

                ?>
                    <?php

                    $this->view('admin/perhitungan/partial/dataset', [
                        'headerDataset' => $headerDataset,
                        'arr_dataset' => $arr_dataset
                    ]);
                    ?>

                    <?php
                    $this->view('admin/perhitungan/partial/transformasi', [
                        'headerDataset' => $headerDataset,
                        'kmeans' => $kmeans
                    ]);
                    ?>
                    <?php
                    $this->view('admin/perhitungan/partial/iterasi', [
                        'kmeans' => $kmeans,
                        'convertCluster' => $convertCluster
                    ]);
                    ?>
                    <div class="card">
                        <div class="card-header bg-success">
                            <strong class="text-white">
                                <i class="fas fa-save"></i> Simpan
                            </strong>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg btn-submit">
                                <i class="fas fa-paper-plane"></i> Submit
                            </button>
                        </div>
                    </div>
                    <?php
                    $this->view('admin/perhitungan/partial/output', [
                        'hasil_centroid' => $hasil_centroid,
                        'hasil_jarak' => $hasil_jarak,
                        'hasil_convertKedekatan' => $hasil_convertKedekatan,
                    ]);
                    ?>

                    <?php
                    $this->view('admin/perhitungan/partial/pengujian', [
                        'pengujian' => $pengujian
                    ]);
                    ?>


                <?php endif; ?>
            </div>
        </div>



    </div>
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>

<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table-dataset').DataTable();
        $('#table-transformasi').DataTable();
        $('#table-jarak-hasil').DataTable();
        $('#table-output-centroid').DataTable();
        $('#table-kelompok-hasil').DataTable();
        $('#table-hasil-pengujian').DataTable();
        let iterasi = "";
        <?php foreach ($kmeans['getCenterMedoid'] as $iterasi => $vCenterMedoid) : ?>
            iterasi = "<?= $iterasi ?>";
            $('#table-centroid-' + iterasi).DataTable();
            $('#table-jarak-' + iterasi).DataTable();
        <?php endforeach; ?>

        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            const root = "<?= base_url() ?>";
            Swal.fire({
                title: 'Info',
                text: "Apakah anda ingin submit ?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirmed'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = root + '/Admin/Perhitungan/submit';
                }
            })
        })
    })
</script>
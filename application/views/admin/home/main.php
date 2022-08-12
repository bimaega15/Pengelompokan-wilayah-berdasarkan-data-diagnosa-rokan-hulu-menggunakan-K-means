<?php
$konfigurasi = konfigurasi();
?>
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
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="fas fa-user-lock"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Users</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $users; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-diabetes"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Dataset</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $dataset; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="fas fa-table"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Inisialisasi</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $inisialisasi; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="<?= base_url('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi); ?>" class="img-fluid" alt="Gambar Naive Bayes">
                            </div>
                            <div class="col-lg-8">
                                <h3 class="mb-3"> <u>Pengelompokan K-means</u> </h3>
                                <div class="text-dark tentang">
                                    <?= $konfigurasi->tentang_konfigurasi; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>
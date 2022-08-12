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
                    <?php $this->view('session'); ?>
                    <div class="card-body">
                        <a data-toggle="modal" data-target="#modalForm" href="#" class="btn btn-primary btn-add"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                        <a data-toggle="modal" data-target="#modalImport" href="#" class="btn btn-success btn-add"><i class="fas fa-file-excel"></i> Import Data</a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Bobot</th>
                                        <th>Inisialisasi</th>
                                        <th class="text-center" width="20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="map"></div>
                </div>
            </div>
        </div>



    </div>
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormInisialisasiDetail" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormInisialisasiDetail"> Form Inisialisasi Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/InisialisasiDetail/process') ?>" method="post" class="form-submit">
                <input type="hidden" name="page" value="">
                <input type="hidden" name="inisialisasi_id" value="<?= $inisialisasi_id ?>">
                <input type="hidden" name="id_inisialisasi_detail" value="">
                <input type="hidden" name="letak_coordinate">
                <div class="modal-body">
                    <div id="error_modal"></div>
                    <div class="form-group">
                        <label for="">Nama Inisialisasi</label>
                        <input type="text" class="form-control" placeholder="Nama Inisialisasi Detail" name="nama_inisialisasi_detail">
                    </div>
                    <div class="form-group">
                        <label for="">Bobot Inisialisasi</label>
                        <input type="number" step="any" class="form-control" placeholder="Bobot inisialisasi" name="bobot_inisialisasi_detail">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-redo"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit"> <i class="fas fa-save"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportInisialisasiDetail" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportInisialisasiDetail"> Form Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/InisialisasiDetail/import') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="page" value="">
                <input type="hidden" name="inisialisasi_id" value="<?= $inisialisasi_id; ?>">
                <input type="hidden" name="coordinate" value="">
                <div class="modal-body">
                    <div id="error_modal"></div>
                    <div class="form-group">
                        <label for="">Import file (Excel)</label>
                        <input type="file" class="form-control" name="import" required accept=".xls, .xlsx">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-redo"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('node_modules/mapbox-gl/dist/mapbox-gl.js') ?>"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<script>
    $(document).ready(function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoiYmltYWVnYTEyIiwiYSI6ImNrcXFxbDd6cTAza3oyd215dDNvNWJ2d20ifQ.obyTqre9zTXcmd5XXWvw1A';
        let map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/dark-v10',
            center: [100.528906, 0.713729], // starting position [lng, lat]
            zoom: 8 // starting zoom
        });

        let mapboxClient = mapboxSdk({
            accessToken: mapboxgl.accessToken
        });

        function geoMap() {
            let val = $('input[name="nama_inisialisasi_detail"]').val();
            mapboxClient.geocoding
                .forwardGeocode({
                    query: val,
                    autocomplete: false,
                    limit: 1
                })
                .send()
                .then((response) => {
                    if (
                        !response ||
                        !response.body ||
                        !response.body.features ||
                        !response.body.features.length
                    ) {
                        console.error('Invalid response:');
                        console.error(response);
                        return;
                    }
                    const feature = response.body.features[0].center;
                    $('input[name="letak_coordinate"]').val(feature);
                });
        }
        $(document).on('change', 'input[name="nama_inisialisasi_detail"]', function() {
            geoMap();
        })

        var table = $('#dataTable').DataTable({
            "ajax": {
                url: "<?= base_url('Admin/InisialisasiDetail/loadData') ?>",
                type: 'get',
                data: {
                    inisialisasi_id: "<?= $inisialisasi_id ?>"
                }
            },
        });

        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
            $('.form-submit')[0].reset();
            resetForm();
            $('input[name="page"]').val('add');
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            const id_inisialisasi_detail = $(this).data('id_inisialisasi_detail');
            $.ajax({
                url: '<?= base_url('Admin/InisialisasiDetail/edit/') ?>' + id_inisialisasi_detail,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const {
                        row
                    } = data;

                    $('input[name="id_inisialisasi_detail"]').val(row.id_inisialisasi_detail);
                    $('input[name="nama_inisialisasi_detail"]').val(row.nama_inisialisasi_detail);
                    $('input[name="bobot_inisialisasi_detail"]').val(row.bobot_inisialisasi_detail);

                    $('#modalForm').modal().show();
                    $('input[name="page"]').val('edit');
                    geoMap();
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        function resetForm() {
            $('#error_modal').html('');
            $('.form-submit').trigger("reset");
        }
        $(document).on('click', '.btn-submit', function(e) {
            geoMap();
            let coordinate = $('input[name="letak_coordinate"]').val();
            if (coordinate != '' && coordinate != null) {
                e.preventDefault();
                var form = $('.form-submit')[0];
                var data = new FormData(form);
                $.ajax({
                    url: '<?= base_url('Admin/InisialisasiDetail/process') ?>',
                    type: "POST",
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 'error') {
                            var output = ``;
                            $.each(data.output, function(index, value) {
                                output += `
                                    <div class="alert alert-danger alert-dismissible fade show mb-1" role="alert">
                                        <strong>Fail!</strong>${value}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    `;
                            })
                            $('#error_modal').html(output);
                        }

                        if (data.status_db == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully',
                                text: data.output,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            $('#modalForm').modal('hide');
                            table.ajax.reload();
                            resetForm();
                        }

                        if (data.status_db == 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: data.output,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            $('#modalForm').modal('hide');
                            table.ajax.reload();
                        }
                    },
                    error: function(x, t, m) {
                        console.log(x.responseText);
                    }
                });
            }

        })
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_inisialisasi_detail = $(this).data("id_inisialisasi_detail");
            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin menghapus item ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Admin/InisialisasiDetail/delete') ?>",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id_inisialisasi_detail
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'success'
                                );
                                table.ajax.reload();

                            } else {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'error'
                                )
                            }

                        },
                        error: function(x, t, m) {
                            console.log(x.responseText);
                        }
                    })
                }
            })
        })
    })
</script>
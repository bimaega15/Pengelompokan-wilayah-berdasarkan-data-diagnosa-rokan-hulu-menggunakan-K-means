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
                        <a data-toggle="modal" data-target="#modalForm" href="<?= base_url('Admin/DataSet/add') ?>" class="btn btn-primary btn-add"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                        <a data-toggle="modal" data-target="#modalImport" href="<?= base_url('Admin/DataSet/add') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Data</a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode DataSet</th>
                                        <th class="text-center" width="20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormDataSet" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormDataSet"> Form DataSet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/DataSet/process') ?>" method="post" class="form-submit">
                <input type="hidden" name="page" value="">
                <input type="hidden" name="id_dataset" value="">
                <input type="hidden" name="id_dataset_detail" value="">
                <div class="modal-body">
                    <div id="error_modal"></div>
                    <div class="form-group">
                        <label for="">Kode DataSet</label>
                        <input type="text" name="kode_dataset" placeholder="Nama DataSet..." class="form-control" value="<?= kodeDataSet() ?>" readonly>
                    </div>
                    <?php foreach ($inisialisasi as $id_inisialisasi => $v_inisialisasi) {
                        $getInisialisasi = check_inisialisasi($id_inisialisasi)->row();
                        echo '
                        <div class="form-group">
                            <label for="">' . ucwords($getInisialisasi->nama_inisialisasi) . '</label>
                            <select name="inisialisasi_detail_id[' . $id_inisialisasi . ']" class="form-control select2 inisialisasi_detail_id" id="">
                                <option value="">-- Inisialisasi detail --</option>';
                        foreach ($v_inisialisasi as $key => $v_inisialisasi_detail) {
                            echo '
                            <option value="' . $v_inisialisasi_detail->id_inisialisasi_detail . '">' . $v_inisialisasi_detail->nama_inisialisasi_detail . '</option>
                            ';
                        }
                        echo '
                            </select>
                        </div>
                            ';
                    } ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-redo"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit"> <i class="fas fa-save"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportDataSet" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportDataSet"> Form Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/Dataset/import') ?>" method="post" class="form-submit" enctype="multipart/form-data">
                <input type="hidden" name="page" value="">
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

<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailDataSet" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailDataSet">Detail DataSet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="load_data_set"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-check"></i> OK</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap'
        });

        var table = $('#dataTable').DataTable({
            "ajax": "<?= base_url('Admin/DataSet/loadData') ?>",
        });

        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
            $('.form-submit')[0].reset();
            resetForm();
            $('input[name="page"]').val('add');
            $('input[name="kode_dataset"]').attr('readonly', false);

            $.ajax({
                url: '<?= base_url('Admin/DataSet/kodeDataSet') ?>',
                dataType: 'json',
                type: 'post',
                success: function(data) {
                    $('input[name="kode_dataset"]').val(data);
                },
                error: function(x, t, m) {
                    console.log(x.responseJSON);
                }
            })
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            const id_dataset = $(this).data('id_dataset');
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const {
                        row,
                        dataset
                    } = data;

                    $('input[name="id_dataset"]').val(row.id_dataset);
                    $('input[name="kode_dataset"]').val(row.kode_dataset);
                    let push = [];
                    $.each(dataset, function(i, v) {
                        $('select[name="inisialisasi_detail_id[' + v.id_inisialisasi + ']"] option[value="' + v.id_inisialisasi_detail + '"]').attr('selected', true).trigger('change');
                        push.push(v.id_dataset_detail);
                    })
                    let join = push.join(',');
                    $('input[name="id_dataset_detail"]').val(join);

                    $('#modalForm').modal().show();
                    $('input[name="page"]').val('edit');
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        function titleCase(str) {
            var splitStr = str.toLowerCase().split(' ');
            for (var i = 0; i < splitStr.length; i++) {
                splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
            }
            return splitStr.join(' ');
        }
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();
            const id_dataset = $(this).data('id_dataset');
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    let output = ``;
                    $.each(data, function(i, v) {
                        output += `
                            <div class="form-group">
                                <h5>${titleCase(v.nama_inisialisasi)}</h5>
                                <span>${v.nama_inisialisasi_detail}</span>
                            </div>
                        `
                    });

                    $('#load_data_set').html(`
                    ${output}
                    `);
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        function resetForm() {
            $('#error_modal').html('');
            $('.form-submit').trigger("reset");
            $('.inisialisasi_detail_id option').attr('selected', false).trigger('change');
        }

        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            var form = $('.form-submit')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/DataSet/process') ?>',
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
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
        })
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_dataset = $(this).data("id_dataset");
            let url = $(this).attr('href');

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
                        url: url,
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id_dataset
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
                                    'success'
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
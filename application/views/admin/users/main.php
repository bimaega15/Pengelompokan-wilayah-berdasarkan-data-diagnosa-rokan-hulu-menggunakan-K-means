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
                        <a data-toggle="modal" data-target="#modalForm" class="btn btn-primary btn-add text-white"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>No. HP</th>
                                        <th>Alamat</th>
                                        <th>J.kelamin</th>
                                        <th>Gambar</th>
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
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormUsers" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormUsers"> Form Data Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/Users/process') ?>" method="post" class="form-submit" enctype="multipart/form-data">
                <input type="hidden" name="page" value="">
                <input type="hidden" name="password_old" value="">
                <input type="hidden" name="id_users">
                <input type="hidden" name="profile_id">
                <div class="modal-body">
                    <div id="error_modal"></div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="username" placeholder="Username..." class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" placeholder="Password..." class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm password..." class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Level</label>
                        <select name="level" class="form-control" id="">
                            <option value="">-- Level --</option>
                            <option value="admin">Admin</option>
                            <option value="users">Users</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama_profile" class="form-control" placeholder="Nama profile">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea class="form-control alamat_profile" placeholder="Alamat" name="alamat_profile">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="">No. HP</label>
                        <input type="number" name="nohp_profile" class="form-control" placeholder="No. HP">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="jenis_kelamin_profile" type="radio" id="jenis_kelamin_profile1" value="L">
                            <label class="form-check-label" for="jenis_kelamin_profile1">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="jenis_kelamin_profile" type="radio" id="jenis_kelamin_profile2" value="P">
                            <label class="form-check-label" for="jenis_kelamin_profile2">Perempuan</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar profile</label>
                        <input type="file" name="gambar_profile" class="form-control">
                        <span id="load_gambar_profile"></span>
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
<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var pane = $('.alamat_profile');
        pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
            .replace(/(<[^\/][^>]*>)\s*/g, '$1')
            .replace(/\s*(<\/[^>]+>)/g, '$1'));

        var table = $('#dataTable').DataTable({
            "ajax": "<?= base_url('Admin/Users/loadData') ?>",
        });

        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
            $('.form-submit')[0].reset();
            resetForm();
            $('input[name="page"]').val('add');
            var pane = $('.alamat_profile');
            pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                .replace(/\s*(<\/[^>]+>)/g, '$1'));
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            const id_users = $(this).data('id_users');
            const root = "<?= base_url('') ?>";
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const {
                        row
                    } = data;

                    $('input[name="username"]').val(row.username);
                    $('input[name="password_old"]').val(row.password);
                    $('select[name="level"]').val(row.level);
                    $('input[name="id_users"]').val(row.id_users);

                    $('input[name="profile_id"]').val(row.id_profile);
                    $('input[name="nama_profile"]').val(row.nama_profile);
                    $('textarea[name="alamat_profile"]').val(row.alamat_profile);
                    $('input[name="nohp_profile"]').val(row.nohp_profile);
                    $('input[name="jenis_kelamin_profile"][value="' + row.jenis_kelamin_profile + '"]').attr('checked', true);
                    $('#load_gambar_profile').html(`
                    <img class="img-thumbnail" width="25%;" src="${root}/public/image/users/${row.gambar_profile}"></img>
                    `);

                    $('#modalForm').modal().show();
                    $('input[name="page"]').val('edit');
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        function resetForm() {
            $('#error_modal').html('');
            $('#load_gambar_profile').html('');
            $('select[name="level"] option').attr('selected', false);
            $('input[name="jenis_kelamin_profile"]').attr('checked', false);
            $('.form-submit').trigger("reset");
        }
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            var form = $('.form-submit')[0];
            var data = new FormData(form);
            let url = $('.form-submit').attr('action');
            $.ajax({
                url: url,
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
            const id_users = $(this).data("id_users");
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
                            id_users
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
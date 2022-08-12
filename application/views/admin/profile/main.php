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
                    <span id="error_modal"></span>
                    <?php $this->view('session'); ?>
                    <div class="card-body" id="loadProfile">
                        <form action="<?= base_url('Admin/Profile/process') ?>" method="post" class="form-submit">
                            <input type="hidden" name="page" value="<?= $page; ?>">
                            <input type="hidden" name="id_users" value="<?= $result->id_users; ?>">
                            <input type="hidden" name="profile_id" value="<?= $result->id_profile; ?>">
                            <input type="hidden" name="password_old" value="<?= $result->password; ?>">

                            <div class="text-center">
                                <img src="<?= base_url('public/image/users/' . $result->gambar_profile) ?>" class="img-thumbnail rounded" alt="Gambar profile" width="150px;">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="username" class="form-control" value="<?= $result->username; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Level</label>
                                        <select name="level" class="form-control" id="">
                                            <option value="">-- Level --</option>
                                            <option value="admin" <?= $result->level == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="users" <?= $result->level == 'users' ? 'selected' : '' ?>>Users</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="text" name="password" class="form-control" value="" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Confirmation Password</label>
                                        <input type="text" name="password_confirmation" class="form-control" value="" placeholder="Confirmation password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama_profile" class="form-control" placeholder="Nama profile" value="<?= $result->nama_profile ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea name="alamat_profile" class="form-control alamat_profile" placeholder="Alamat profile">
                               <?= $result->alamat_profile ?>
                               </textarea>
                            </div>

                            <div class="form-group">
                                <label for="">No. HP</label>
                                <input type="number" name="nohp_profile" class="form-control" placeholder="No. HP" value="<?= $result->nohp_profile; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Kelamin</label> <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin_profile" id="jenis_kelamin_profile1" value="L" <?= $result->jenis_kelamin_profile == 'L' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jenis_kelamin_profile1">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin_profile" id="jenis_kelamin_profile2" value="P" <?= $result->jenis_kelamin_profile == 'P' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jenis_kelamin_profile2">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Gambar profile</label>
                                <input type="file" name="gambar_profile" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-redo"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary btn-submit"> <i class="fas fa-save"></i> Submit</button>
                            </div>
                        </form>
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

<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var pane = $('.alamat_profile');
        pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
            .replace(/(<[^\/][^>]*>)\s*/g, '$1')
            .replace(/\s*(<\/[^>]+>)/g, '$1'));

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
                        $('#loadProfile').load('<?= current_url() ?> #loadProfile > *');
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

        function resetForm() {
            $('#error_modal').html('');
            $('#load_gambar_profile').html('');
            $('select[name="level"] option').attr('selected', false);
            $('input[name="jenis_kelamin_profile"]').attr('checked', false);
            $('.form-submit').trigger("reset");
        }
    })
</script>
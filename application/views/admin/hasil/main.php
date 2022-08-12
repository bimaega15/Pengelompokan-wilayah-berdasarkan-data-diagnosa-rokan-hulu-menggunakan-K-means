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
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Iterasi</th>
                                    <th>Jumlah cluster</th>
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

<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalHasilDetail" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHasilDetail">Detail Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="load_hasil_detail"></div>
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
        var table = $('#dataTable').DataTable({
            "ajax": "<?= base_url('Admin/Hasil/loadData') ?>",
        });

        function number_format(number, decimals, dec_point, thousands_point) {
            if (number == null || !isFinite(number)) {
                throw new TypeError("number is not valid");
            }

            if (!decimals) {
                var len = number.toString().split('.').length;
                decimals = len > 1 ? len : 0;
            }

            if (!dec_point) {
                dec_point = '.';
            }

            if (!thousands_point) {
                thousands_point = ',';
            }

            number = parseFloat(number).toFixed(decimals);

            number = number.replace(".", dec_point);

            var splitNum = number.split(dec_point);
            splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
            number = splitNum.join(dec_point);

            return number;
        }

        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();
            const id_hasil = $(this).data('id_hasil');
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    let output = ``;
                    $.each(data, function(i, v) {
                        let cluster = parseInt(v.cluster) + parseInt(1);
                        let jarak = number_format(v.jarak, 3);
                        output += `
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <p class="m-0 p-0">Kode</p>
                                    <span>${v.kode_dataset}</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <p class="m-0 p-0">Cluster</p>
                                    <span>${cluster}</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <p class="m-0 p-0">Jarak</p>
                                    <span>${jarak}</span>
                                </div>
                            </div>
                        </div>
                        `
                    });

                    $('#load_hasil_detail').html(`
                    ${output}
                    `);
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_hasil = $(this).data("id_hasil");
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
                            id_hasil
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
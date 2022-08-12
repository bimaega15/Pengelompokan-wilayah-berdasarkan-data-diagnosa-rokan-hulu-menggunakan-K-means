<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Dataset
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="table-dataset">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <?php
                        foreach ($headerDataset as $key => $vHeader) {
                            echo '<th>' . ucwords($vHeader->nama_inisialisasi) . '</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($arr_dataset as $dataset_id => $v_dataset) {
                        $getDataset = check_dataset($dataset_id)->row();

                        echo '
                                        <tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . $getDataset->kode_dataset . '</td>';
                        foreach ($v_dataset as $key => $value) {
                            echo '
                                                <td>' . $value->nama_inisialisasi_detail . '</td>
                                                ';
                        }
                        echo '
                                        </tr>
                                           ';
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
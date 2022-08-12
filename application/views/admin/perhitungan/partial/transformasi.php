<div class="card mt-1">
    <div class="card-header">
        <i class="fas fa-table"></i> Transformasi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="table-transformasi">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <?php
                        $no = 1;
                        foreach ($headerDataset as $key => $vHeader) {
                            echo '<th>K' . $no++ . '</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($kmeans['transformasi'] as $dataset_id => $v_dataset) {
                        $getDataset = check_dataset($dataset_id)->row();

                        echo '
                                        <tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . $getDataset->kode_dataset . '</td>';
                        foreach ($v_dataset as $id_dataset_detail => $value) {
                            echo '
                                                <td>' . $value . '</td>
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
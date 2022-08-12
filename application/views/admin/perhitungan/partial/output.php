<!-- output hasil -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Output hasil
    </div>
    <div class="card-body">
        <div class="mb-1">
            <strong>Centroid Medoid</strong>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-output-centroid">
                    <?php
                    $headerHasil = [];
                    foreach ($hasil_centroid as $key => $vHeader) {
                        $headerHasil = $vHeader;
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>Cluster</th>
                            <th>Objek</th>
                            <?php
                            $no = 1;
                            foreach ($headerHasil as $key => $vHasil) :
                            ?>
                                <th>K<?= $no++; ?></th>
                            <?php
                            endforeach;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($hasil_centroid as $dataset_id => $v_dataset) :
                            $getDataset = check_dataset($dataset_id)->row();
                        ?>
                            <tr>
                                <td>C<?= $no++; ?></td>
                                <td><?= $getDataset->kode_dataset; ?></td>
                                <?php
                                foreach ($v_dataset as $key => $value) : ?>
                                    <td><?= round($value, 3); ?></td>
                                <?php
                                endforeach;
                                ?>
                            </tr>

                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-1">
            <strong>Jarak</strong>
            <?php
            $headerJarak = [];
            foreach ($hasil_jarak as $key => $v_jarak) :
                $headerJarak = $v_jarak;
            endforeach;

            ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-jarak-hasil">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <?php
                            $no = 1;
                            foreach ($headerJarak as $key => $vHeaderCenter) :
                            ?>
                                <th>Jarak C<?= $no++; ?></th>
                            <?php
                            endforeach;
                            ?>
                            <th>Kedekatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no_cluster = 1;
                        $kedekatan = $hasil_convertKedekatan;
                        foreach ($hasil_jarak as $dataset_id => $v_dataset) :
                            $getDataset = check_dataset($dataset_id)->row();

                            echo '<tr>';
                            echo '<td>' . $no_cluster . '</td>';
                            echo '<td>' . $getDataset->kode_dataset . '</td>';
                            foreach ($v_dataset as $key => $value) :
                                echo '<td>' . round($value, 3) . '</td>';
                            endforeach;
                            echo '<td>
                                <div class="text-center">
                                    ' . ($kedekatan[$dataset_id] + 1) . '
                                </div>
                            </td>';
                            echo '</tr>';
                            $no_cluster++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mb-1">
    <strong>Centroid Medoid</strong>
    <div class="table-responsive">
        <table class="table table-bordered" id="table-centroid-<?= $iterasi; ?>">
            <thead>
                <tr>
                    <th>Cluster</th>
                    <?php
                    if ($iterasi == 1) :
                    ?>
                        <th>Objek</th>
                    <?php
                    endif;
                    ?>
                    <?php
                    $no = 1;
                    foreach ($headerCenterMedoid as $key => $vHeaderCenter) :
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
                foreach ($vCenterMedoid as $dataset_id => $v_dataset) :
                    $getDataset = check_dataset($dataset_id)->row();
                    $getCluster =  $convertCluster[$dataset_id][$dataset_id];
                ?>
                    <tr>
                        <td>C<?= ($getCluster + 1); ?></td>
                        <?php
                        if ($iterasi == 1) :
                        ?>
                            <td><?= $getDataset->kode_dataset; ?></td>
                        <?php
                        endif;
                        ?>
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
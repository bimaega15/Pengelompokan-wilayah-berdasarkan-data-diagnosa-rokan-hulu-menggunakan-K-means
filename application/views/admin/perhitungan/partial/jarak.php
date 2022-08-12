<div class="mb-1">
    <strong>Jarak</strong>
    <?php
    $jarak = $kmeans['jarak'];
    $headerJarak = [];
    foreach ($jarak as $key => $v_jarak) :
        foreach ($v_jarak as $key => $value) :
            $headerJarak = $value;
            break;
        endforeach;
    endforeach;

    ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="table-jarak-<?= $iterasi; ?>">
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
                $kedekatan = $kmeans['convertKedekatan'][$iterasi];
                foreach ($jarak[$iterasi] as $dataset_id => $v_dataset) :
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
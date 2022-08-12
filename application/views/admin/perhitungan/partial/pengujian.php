<!-- output hasil -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Hasil Pengujian
    </div>
    <div class="card-body">
        <div class="mb-1">
            <strong>Data Transformasi</strong>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-kelompok-hasil">
                    <?php
                    $header = $pengujian['kelompokHasil'];
                    foreach ($header as $key => $value) {
                        $max  = count($value) - 1;
                        unset($value[$max]);
                        $count = count($value);
                        break;
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <?php
                            for ($i = 1; $i <= $count; $i++) : ?>
                                <th>X<?= $i; ?></th>
                            <?php
                            endfor;
                            ?>
                            <th>Klaster/Hasil</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $no = 1;
                        foreach ($pengujian['kelompokHasil'] as $dataset_id => $v_dataset) :
                            $getDataset = check_dataset($dataset_id)->row();
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $getDataset->kode_dataset; ?></td>
                                <?php
                                foreach ($v_dataset as $key => $value) :
                                ?>
                                    <td><?= ($value); ?></td>
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
            <strong>Pengujian</strong>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-hasil-pengujian">
                    <?php
                    foreach (($pengujian['row']) as $key => $value) {
                        $countCluster = ($value['cluster']);
                        $countCluster = count($countCluster);
                        break;
                    };
                    ?>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ai</th>
                            <?php
                            for ($i = 1; $i <= $countCluster; $i++) : ?>
                                <th>d(i,<?= $i; ?>)</th>
                            <?php
                            endfor;
                            ?>
                            <th>b(i)</th>
                            <th>SI(i)</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pengujian['row'] as $dataset_id => $value) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= round($value['ai'], 3); ?></td>
                                <?php
                                foreach ($value['cluster'] as $key => $r_value) :
                                    if ($r_value != '-') :
                                        echo ' <td>' . round($r_value, 3) . ' </td>';
                                    else :
                                        echo ' <td> ' . $r_value . ' </td>';
                                    endif;
                                ?>
                                <?php
                                endforeach;
                                ?>
                                <td><?= round($value['bi'], 3); ?></td>
                                <td><?= round($value['SIi'], 3) ?></td>
                                <?php
                                $rowCount = null;
                                $getValue = null;
                                $getValueMany = null;
                                $rowValueMany = null;
                                foreach ($pengujian['convertSIjToIndex'] as $cluster => $v_cluster) {
                                    $indexPertama = ($v_cluster[0]);
                                    if ($indexPertama == $dataset_id) {
                                        $rowCount = count($v_cluster);
                                        $res_val = $pengujian['result'][$cluster];
                                        $getValue = array_sum($res_val) / count($res_val);

                                        if ($cluster == 0) {
                                            $rowValueMany = count($pengujian['row']);
                                            $getValueMany = $pengujian['result_many'];
                                        }
                                    }
                                }
                                ?>
                                <!-- <?php
                                        if ($rowCount != null) : ?>
                                    <td rowspan="<?= $rowCount; ?>" style="vertical-align: middle;">
                                        <?= round($getValue, 3); ?>
                                    </td>
                                <?php
                                        endif;
                                ?>
                                <?php
                                if ($rowValueMany != null) : ?>
                                    <td rowspan="<?= $rowValueMany; ?>" style="vertical-align: middle;">
                                        <?= round($getValueMany, 3); ?>
                                    </td>
                                <?php
                                endif;
                                ?> -->
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-1">
            <div class="row">
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">SI (j)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($pengujian['result'] as $dataset_id => $value) :
                                    $total = array_sum($value) / count($value);
                                ?>
                                    <tr>
                                        <td class="text-center"><?= round($total, 3); ?></td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">SI (g)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="<?= count($pengujian['result']) ?>" class="text-center"><?= round($pengujian['result_many'], 3) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
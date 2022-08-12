<?php
$headerCenterMedoid = [];
foreach ($kmeans['getCenterMedoid'] as $iterasi => $vCenterMedoid) :
    foreach ($vCenterMedoid as $key => $value) :
        $headerCenterMedoid = $value;
        break;
    endforeach;
endforeach;

foreach ($kmeans['getCenterMedoid'] as $iterasi => $vCenterMedoid) :
?>
    <div class="accordion" id="accordionIterasi-<?= $iterasi ?>">
        <div class="card">
            <div class="card-header m-0 p-0 bg-primary" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapse-<?= $iterasi ?>" aria-expanded="true" aria-controls="collapse-<?= $iterasi ?>">
                        <strong style="font-size: 18px;">
                            Iterasi <?= ($iterasi) ?>
                        </strong>
                    </button>
                </h2>
            </div>

            <div id="collapse-<?= $iterasi ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionIterasi-<?= $iterasi ?>">
                <div class="card-body">
                    <?php
                    $this->view('admin/perhitungan/partial/centroid-medoid', [
                        'headerCenterMedoid' => $headerCenterMedoid,
                        'vCenterMedoid' => $vCenterMedoid,
                        'iterasi' => $iterasi,
                        'convertCluster' => $convertCluster
                    ]);
                    ?>

                    <?php
                    $this->view('admin/perhitungan/partial/jarak', [
                        'iterasi' => $iterasi,
                        'kmeans' => $kmeans
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
endforeach;
?>
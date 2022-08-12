<?php
class Kmeans
{
    public function __construct()
    {
    }
    public function arr_dataset()
    {
        $ci = &get_instance();
        $ci->load->model('DatasetDetail/DatasetDetail_model');
        $save_array = [];
        $arr_dataset = [];
        $dataset_id_index = [];
        $dataset = $ci->DatasetDetail_model->get()->result();
        $jumlah_cluster = 3;
        foreach ($dataset as $key => $r_dataset) {
            $arr_dataset[$r_dataset->dataset_id][] = $r_dataset;
            $dataset_id_index[$r_dataset->dataset_id] = $r_dataset->dataset_id;
        }
        return [
            'arr_dataset' => $arr_dataset,
            'dataset_id_index' => $dataset_id_index,
        ];
    }
    public function get_dataset_id_index($dataset_id_index)
    {
        $index = 0;
        $get_dataset_id_index = [];
        $convert_get_dataset_id_index = [];
        foreach ($dataset_id_index as $dataset_id => $value) {
            $get_dataset_id_index[$dataset_id] = $index;
            $convert_get_dataset_id_index[$index] = $dataset_id;
            $index++;
        }
        return [
            'get_dataset_id_index' => $get_dataset_id_index,
            'convert_get_dataset_id_index' => $convert_get_dataset_id_index
        ];
    }
    public function transformasi($arr_dataset)
    {
        $transformasi = [];
        $convert_get_dataset_detail_id_index = [];
        $convert_get_index_dataset_detail = [];
        foreach ($arr_dataset as $dataset_id => $v_dataset) {
            $indexPlus = 0;
            foreach ($v_dataset as $index => $r_dataset) {
                $transformasi[$dataset_id][$r_dataset->id_dataset_detail] = $r_dataset->bobot_inisialisasi_detail;

                $convert_get_dataset_detail_id_index[$dataset_id][$r_dataset->id_dataset_detail] = $indexPlus;
                $convert_get_index_dataset_detail[$dataset_id][$indexPlus] = $r_dataset->id_dataset_detail;
                $indexPlus++;
            }
        }
        return [
            'transformasi' => $transformasi,
            'convert_get_dataset_detail_id_index' => $convert_get_dataset_detail_id_index,
            'convert_get_index_dataset_detail' => $convert_get_index_dataset_detail,
        ];
    }
    public function getCenterMedoid($min, $max, $jumlah_cluster, $transformasi)
    {
        $getCenterMedoid = [];
        $getCheckCenterMedoid = [];
        do {
            for ($i = 1; $i <= $jumlah_cluster; $i++) {
                $random_between = random_int($min, $max);
                $search = array_search($random_between, $getCheckCenterMedoid);

                if ($search != null) {
                    do {
                        $random_between = random_int($min, $max);
                        $search = array_search($random_between, $getCheckCenterMedoid);
                    } while ($search != null);
                }
                $getCheckCenterMedoid[$i] = $random_between;
                $getCenterMedoid[$random_between] = $transformasi[$random_between];
            }
            $countCenter = count($getCenterMedoid);
        } while ($countCenter != $jumlah_cluster);


        // $getCenterMedoid = [];
        // $getCenterMedoid[$convert_get_dataset_id_index[5]] = $transformasi[$convert_get_dataset_id_index[5]];
        // $getCenterMedoid[$convert_get_dataset_id_index[12]] = $transformasi[$convert_get_dataset_id_index[12]];
        // $getCenterMedoid[$convert_get_dataset_id_index[16]] = $transformasi[$convert_get_dataset_id_index[16]];
        return $getCenterMedoid;
    }
    public function jarak($transformasi, $convert_get_dataset_detail_id_index, $getCenterMedoid, $convert_get_index_dataset_detail)
    {
        $jarak = [];
        foreach ($transformasi as $dataset_id => $v_dataset) {
            $arr_hitung = [];
            foreach ($v_dataset as $id_dataset_detail => $value) {
                $getIndex1 = $convert_get_dataset_detail_id_index[$dataset_id][$id_dataset_detail];
                foreach ($getCenterMedoid as $dataset_id_2 => $v_dataset2) {
                    $getCenter = $convert_get_index_dataset_detail[$dataset_id_2][$getIndex1];
                    $getCenter = $v_dataset2[$getCenter];
                    $hitung = $getCenter - $value;
                    $pangkat = pow($hitung, 2);
                    $arr_hitung[$dataset_id_2][] = $pangkat;
                }
            }
            // hitung total
            foreach ($arr_hitung as $dataset_id_2 => $v_dataset2) {
                $sum = array_sum($v_dataset2);
                $sqrt = sqrt($sum);
                $jarak[$dataset_id][$dataset_id_2] = $sqrt;
            }
        }
        return $jarak;
    }
    public function convertCluster($jarak)
    {
        $convertCluster = [];
        foreach ($jarak as $dataset_id => $v_jarak) {
            $indexPlus = 0;
            foreach ($v_jarak as $dataset_id_2 => $value) {
                $convertCluster[$dataset_id][$dataset_id_2] = $indexPlus;
                $indexPlus++;
            }
        }
        return $convertCluster;
    }
    public function kedekatan($jarak, $convertCluster)
    {
        $kedekatan = [];
        $convertKedekatan = [];
        foreach ($jarak as $dataset_id => $v_jarak) {
            $min = min($v_jarak);
            $search = array_search($min, $v_jarak);

            $getCluster = $convertCluster[$dataset_id][$search];
            $convertKedekatan[$dataset_id] = $getCluster;
            $kedekatan[$dataset_id] = $search;
        }
        return [
            'kedekatan' => $kedekatan,
            'convertKedekatan' => $convertKedekatan,
        ];
    }
    public function merge($transformasi, $kedekatan, $convertKedekatan)
    {
        $merge = [];
        $hasilMerge = [];
        foreach ($transformasi as $dataset_id => $v_transformasi) {
            $getKedekatan = $kedekatan[$dataset_id];
            // $getKedekatan = $convertKedekatan[$getKedekatan];

            foreach ($v_transformasi as $id_dataset_detail => $value) {
                $merge[$getKedekatan][$dataset_id][] = $value;
            }
        }
        ksort($merge);
        return $merge;
    }

    public function inversMerge($merge)
    {
        $inverseMerge = [];
        foreach ($merge as $dataset_id => $v_transformasi) {
            foreach ($v_transformasi as $id_dataset_detail => $value) {
                foreach ($value as $index => $row) {
                    $inverseMerge[$dataset_id][$index][] = $row;
                }
            }
        }
        return $inverseMerge;
    }
    public function centroidBaru($inverseMerge, $convert_get_index_dataset_detail)
    {
        $centroidBaru = [];
        foreach ($inverseMerge as $dataset_id => $v_dataset) {
            foreach ($v_dataset as $index => $value) {
                $hitung = array_sum($value) / count($value);
                $getDatsetDetail = $convert_get_index_dataset_detail[$dataset_id][$index];
                $centroidBaru[$dataset_id][$getDatsetDetail] = $hitung;
            }
        }
        return $centroidBaru;
    }

    public function checkCentroidMedoid($banding, $convertKedekatan, $centroidBaru, $iterasi)
    {
        $checkKedekatan[$banding] = $convertKedekatan;
        $getCenterMedoid = $centroidBaru;

        $boolean = null;
        var_dump($iterasi);
        if ($iterasi >= 2) {
            $checkKedekatan1 = $checkKedekatan[$banding - 1];
            $checkKedekatan2 = $checkKedekatan[$banding];

            $boolean = true;
            foreach ($checkKedekatan1 as $dataset_id => $vKedekataan) {
                $getCheck2 = $checkKedekatan2[$dataset_id];
                if ($vKedekataan != $getCheck2) {
                    $boolean = false;
                }
            }
        }
        return [
            'boolean' => $boolean,
            'checkKedekatan' => $checkKedekatan
        ];
    }

    // pengujian
    public function kelompokHasil($transformasi, $hasil_convertKedekatan)
    {
        $kelompokHasil = [];
        foreach ($transformasi as $dataset_id => $v_transformasi) {
            $index = 0;
            foreach ($v_transformasi as $id_dataset_detail => $value) {
                $kelompokHasil[$dataset_id][$index] = $value;
                $index++;
            }
            array_push($kelompokHasil[$dataset_id], ($hasil_convertKedekatan[$dataset_id] + 1));
        }
        return $kelompokHasil;
    }
    public function kelompokClusterHasil($kelompokHasil)
    {
        $kelompokClusterHasil = [];
        foreach ($kelompokHasil as $dataset_id => $v_transformasi) {
            $max = count($v_transformasi) - 1;
            foreach ($v_transformasi as $id_dataset_detail => $value) {
                $cluster = $v_transformasi[$max];
                $kelompokClusterHasil[$cluster][$dataset_id][$id_dataset_detail] = $value;
            }
        }
        return $kelompokClusterHasil;
    }
    public function ai($kelompokClusterHasil)
    {
        $ai = [];
        $getBandingCluster = $kelompokClusterHasil;
        foreach ($kelompokClusterHasil as $cluster => $v_cluster) {
            foreach ($v_cluster as $dataset_id => $v_dataset) {
                $max = count($v_dataset) - 1;
                unset($v_dataset[$max]);

                // pembanding
                $getDataCluster = $getBandingCluster[$cluster];
                unset($getDataCluster[$dataset_id]);

                // array pembanding
                $sqrtPembanding = [];
                foreach ($getDataCluster as $dataset_id2 => $v_dataset2) {
                    $max2 = count($v_dataset2) - 1;
                    unset($v_dataset2[$max2]);
                    $total = 0;
                    foreach ($v_dataset2 as $id_dataset_detail2 => $value2) {
                        $hitung = $v_dataset[$id_dataset_detail2] - $value2;
                        $pangkat = pow($hitung, 2);
                        $total += $pangkat;
                    }
                    $sqrt = sqrt($total);
                    $sqrtPembanding[$dataset_id2] = $sqrt;
                }
                if (!empty($sqrtPembanding)) {
                    $hitungPembanding = array_sum($sqrtPembanding) / count($sqrtPembanding);
                } else {
                    $hitungPembanding = 0;
                }
                $ai[$dataset_id] = $hitungPembanding;
            }
        }
        return $ai;
    }
    public function di($kelompokClusterHasil)
    {
        $di = [];
        $getClusterDi = $kelompokClusterHasil;
        $pulihkanClusterDi = $kelompokClusterHasil;
        foreach ($kelompokClusterHasil as $cluster => $v_cluster) {
            unset($getClusterDi[$cluster]);
            foreach ($getClusterDi as $cluster2 => $v_cluster2) {
                foreach ($v_cluster2 as $id_dataset_detail2 => $value2) {
                    $max2 = count($value2) - 1;
                    unset($value2[$max2]);
                    $arrBandingHitung = [];
                    foreach ($value2 as $index => $r_value2) {
                        // cluster awal
                        foreach ($v_cluster as $id_dataset_detail => $value) {
                            $max = count($value) - 1;
                            unset($value[$max]);

                            // menghitung perbandingan
                            $hitung = $r_value2 - $value[$index];
                            $pangkat = pow($hitung, 2);
                            $arrBandingHitung[$id_dataset_detail][$index] = $pangkat;
                        }
                    }

                    // hitung sqrt pembanding
                    $hitungTotalSqrt = [];
                    foreach ($arrBandingHitung as $id_dataset_detail => $value) {
                        $hitung = array_sum($value);
                        $sqrt = sqrt($hitung);
                        $hitungTotalSqrt[$id_dataset_detail] = $sqrt;
                    }
                    $hitungHasil = array_sum($hitungTotalSqrt) / count($hitungTotalSqrt);
                    $di[$cluster][$cluster2][$id_dataset_detail2] = $hitungHasil;
                }
            }

            $getClusterDi = $pulihkanClusterDi;
        }
        return $di;
    }
    public function bi($ai, $di)
    {
        $bi = [];
        foreach ($ai as $dataset_id => $value) {
            foreach ($di as $cluster => $v_cluster) {
                foreach ($v_cluster as $cluster2 => $v_cluster2) {
                    if (isset($v_cluster2[$dataset_id])) {
                        $bi[$cluster][$dataset_id] = $v_cluster2[$dataset_id];
                    }
                }
            }
        }


        $fixBi = [];
        $getCluster = [];
        foreach ($ai as $dataset_id => $value) {
            foreach ($bi as $cluster => $v_cluster) {
                $getCluster[$cluster] = $cluster;
                if (isset($v_cluster[$dataset_id])) {
                    $fixBi[$cluster][$dataset_id] = $v_cluster[$dataset_id];
                } else {
                    $fixBi[$cluster][$dataset_id] = '-';
                }
            }
        }

        ksort($getCluster);

        // sorting
        $hasilBi = [];
        foreach ($getCluster as $clusterSort => $sort) {
            foreach ($fixBi as $cluster => $value) {
                if ($clusterSort == $cluster) {
                    $hasilBi[$cluster] = $value;
                }
            }
        }

        // menggabungkan nilai di
        $gabungkanBi = [];
        foreach ($hasilBi as $cluster => $v_cluster) {
            foreach ($v_cluster as $dataset_id => $value) {
                $gabungkanBi[$dataset_id][] = $value;
            }
        }


        // mencari nilai min bi
        $cariMinBi = [];
        foreach ($gabungkanBi as $dataset_id => $value_bi) {
            $index = array_search('-', $value_bi);
            unset($value_bi[$index]);

            $min = min($value_bi);
            $cariMinBi[$dataset_id] = $min;
        }

        return [
            'bi' => $bi,
            'fixBi' => $fixBi,
            'getCluster' => $getCluster,
            'hasilBi' => $hasilBi,
            'gabungkanBi' => $gabungkanBi,
            'cariMinBi' => $cariMinBi,
        ];
    }
    public function SIi($cariMinBi, $ai)
    {
        $SIi = [];
        foreach ($cariMinBi as $dataset_id => $value) {
            $getAi = $ai[$dataset_id];
            $hitung = abs($value - $getAi) / max([$getAi, $value]);
            $SIi[$dataset_id] = $hitung;
        }
        return $SIi;
    }
    public function SIj($SIi, $kelompokClusterHasil)
    {
        $SIj = [];
        foreach ($SIi as $dataset_id => $value) {
            foreach ($kelompokClusterHasil as $cluster => $v_cluster) {
                if (isset($v_cluster[$dataset_id])) {
                    $SIj[$cluster][$dataset_id] = $value;
                }
            }
        }
        return $SIj;
    }
    public function SIg($SIj)
    {
        $fixSIj = [];
        foreach ($SIj as $cluster => $v_dataset) {
            $average = array_sum($v_dataset) / count($v_dataset);
            $fixSIj[$cluster] = $average;
        }

        $SIg = 0;
        $SIg = array_sum($fixSIj) / count($fixSIj);
        return $SIg;
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perhitungan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Inisialisasi/Inisialisasi_model', 'Dataset/Dataset_model', 'DatasetDetail/DatasetDetail_model', 'Hasil/Hasil_model', 'HasilDetail/HasilDetail_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Inisialisasi', 'Admin/Inisialisasi');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $kmeans = new Kmeans();

        // dataset
        $jumlah_cluster = null;
        if (isset($_GET['jumlah_cluster'])) {
            $jumlah_cluster = htmlspecialchars($this->input->get('jumlah_cluster', null));
        }

        if ($jumlah_cluster != null) {
            $save_array = [];
            $arr_dataset = [];
            $dataset_id_index = [];
            $dataset_id_index = $kmeans->arr_dataset()['dataset_id_index'];
            $arr_dataset = $kmeans->arr_dataset()['arr_dataset'];
            $save_array['arr_dataset'] = $arr_dataset;

            // index dataset
            $index = 0;
            $get_dataset_id_index = [];
            $convert_get_dataset_id_index = [];
            $get_dataset_id_index = $kmeans->get_dataset_id_index($dataset_id_index)['get_dataset_id_index'];
            $convert_get_dataset_id_index = $kmeans->get_dataset_id_index($dataset_id_index)['convert_get_dataset_id_index'];


            // transformasi
            $transformasi = [];
            $convert_get_dataset_detail_id_index = [];
            $convert_get_index_dataset_detail = [];
            $transformasi = $kmeans->transformasi($arr_dataset)['transformasi'];
            $convert_get_dataset_detail_id_index = $kmeans->transformasi($arr_dataset)['convert_get_dataset_detail_id_index'];
            $convert_get_index_dataset_detail = $kmeans->transformasi($arr_dataset)['convert_get_index_dataset_detail'];
            $save_array['transformasi'] = $transformasi;

            // get random data
            $min = min($get_dataset_id_index);
            $min = $convert_get_dataset_id_index[$min];
            $max = max($get_dataset_id_index);
            $max = $convert_get_dataset_id_index[$max];

            $getCenterMedoid = [];
            $getCenterMedoid = $kmeans->getCenterMedoid($min, $max, $jumlah_cluster, $transformasi);
            // $getCenterMedoid = [];
            // $getCenterMedoid[$convert_get_dataset_id_index[5]] = $transformasi[$convert_get_dataset_id_index[5]];
            // $getCenterMedoid[$convert_get_dataset_id_index[12]] = $transformasi[$convert_get_dataset_id_index[12]];
            // $getCenterMedoid[$convert_get_dataset_id_index[16]] = $transformasi[$convert_get_dataset_id_index[16]];

            $iterasi = 1;
            $banding = 1;
            // perhitungan manual
            // $getCenterMedoid = [];
            // $getCenterMedoid[6] = $transformasi[6];
            // $getCenterMedoid[13] = $transformasi[13];
            // $getCenterMedoid[15] = $transformasi[15];
            do {
                $save_array['getCenterMedoid'][$iterasi] = $getCenterMedoid;

                // jarak
                $jarak = [];
                $jarak = $kmeans->jarak($transformasi, $convert_get_dataset_detail_id_index, $getCenterMedoid, $convert_get_index_dataset_detail);
                $save_array['jarak'][$iterasi] = $jarak;


                // convert cluster
                $convertCluster = [];
                $convertCluster = $kmeans->convertCluster($jarak);


                // Kedekataan
                $kedekatan = [];
                $convertKedekatan = [];
                $kedekatan = $kmeans->kedekatan($jarak, $convertCluster)['kedekatan'];
                $convertKedekatan = $kmeans->kedekatan($jarak, $convertCluster)['convertKedekatan'];

                $save_array['kedekatan'][$iterasi] = $kedekatan;
                $save_array['convertKedekatan'][$iterasi] = $convertKedekatan;


                // merget
                $merge = [];
                $merge =  $kmeans->merge($transformasi, $kedekatan, $convertKedekatan);

                $inverseMerge = [];
                $inverseMerge = $kmeans->inversMerge($merge);

                // ============================== pengujian
                // centroid
                $centroidBaru = [];
                $centroidBaru = $kmeans->centroidBaru($inverseMerge, $convert_get_index_dataset_detail);

                // check centroid medoid
                $checkKedekatan[$banding] = $convertKedekatan;
                $getCenterMedoid = $centroidBaru;

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

                $iterasi++;
                $banding++;
            } while ($iterasi < 3 || $boolean == false);
            // die;
            $save_array['iterasi'] = $iterasi;
            $save_array['checkKedekatan'] = $checkKedekatan;
        }

        // hasil akhir
        if ($jumlah_cluster != null) {
            $max = (count($save_array['getCenterMedoid']));
            $hasil_centroid = $save_array['getCenterMedoid'][$max];
            $hasil_jarak = $save_array['jarak'][$max];
            $hasil_kedekatan = $save_array['kedekatan'][$max];
            $hasil_convertKedekatan = $save_array['convertKedekatan'][$max];

            $data['hasil_centroid'] = $hasil_centroid;
            $data['hasil_jarak'] = $hasil_jarak;
            $data['hasil_convertKedekatan'] = $hasil_convertKedekatan;
            $data['hasil_iterasi'] = $max;
            $data['kmeans'] = $save_array;
            $data['convertCluster'] = $convertCluster;
        }

        $data['title'] = 'Perhitungan K-means';
        $data['jumlah_cluster'] = $jumlah_cluster;

        // save to session
        if ($jumlah_cluster != null) {
            $save_session_one = [];
            $save_session_one['one'] = [
                'jumlah_cluster' => $jumlah_cluster,
                'iterasi' => $max,
                'users_id' => $this->session->userdata('id_users'),
            ];
            $this->session->set_userdata('kmeans.one', $save_session_one);
            $saveToMany = [];
            foreach ($hasil_jarak as $dataset_id => $v_jarak) {
                $getDataset = check_dataset($dataset_id)->row();
                $hasilKedekatan = $hasil_kedekatan[$dataset_id];
                $hasilJarak = $hasil_jarak[$dataset_id][$hasilKedekatan];
                $saveToMany['onetomany'][] = [
                    'cluster' => $hasil_convertKedekatan[$dataset_id],
                    'jarak' => $hasilJarak,
                    'dataset_id' => $getDataset->id_dataset,
                ];
            }
            $this->session->set_userdata('kmeans.onetomany', $saveToMany);

            // pengujian
            $kelompokHasil = [];
            $kelompokHasil = $kmeans->kelompokHasil($transformasi, $hasil_convertKedekatan);


            $kelompokClusterHasil = [];
            $kelompokClusterHasil = $kmeans->kelompokClusterHasil($kelompokHasil);


            // mencari nilai ai
            $ai = [];
            $ai = $kmeans->ai($kelompokClusterHasil);

            // mencari nilai di
            $di = [];
            $di = $kmeans->di($kelompokClusterHasil);

            // mencari nilai bi
            $bi = [];
            $bi = $kmeans->bi($ai, $di)['bi'];

            $fixBi = [];
            $fixBi = $kmeans->bi($ai, $di)['fixBi'];
            $getCluster = [];
            $getCluster = $kmeans->bi($ai, $di)['getCluster'];


            // sorting
            $hasilBi = [];
            $hasilBi = $kmeans->bi($ai, $di)['hasilBi'];

            // menggabungkan nilai di
            $gabungkanBi = [];
            $gabungkanBi = $kmeans->bi($ai, $di)['gabungkanBi'];

            // mencari nilai min bi
            $cariMinBi = [];
            $cariMinBi = $kmeans->bi($ai, $di)['cariMinBi'];

            // SI i
            $SIi = [];
            $SIi = $kmeans->SIi($cariMinBi, $ai);

            $SIj = [];
            $SIj = $kmeans->SIj($SIi, $kelompokClusterHasil);

            // SIg
            $SIg = 0;
            $SIg = $kmeans->SIg($SIj);

            // gabungkan semua data
            $groupAllData = [];
            foreach ($ai as $dataset_id => $value) {
                $groupAllData[$dataset_id] = [
                    'ai' => $value,
                    'cluster' => $gabungkanBi[$dataset_id],
                    'bi' => $cariMinBi[$dataset_id],
                    'SIi' => $SIi[$dataset_id],
                ];
            }
            // convert SIj
            $convertSIjToIndex = [];
            $convertIndexToSIj = [];
            foreach ($SIj as $cluster => $v_cluster) {
                $indexPlus = 0;
                foreach ($v_cluster as $dataset_id => $value) {
                    $convertSIjToIndex[$cluster][$indexPlus] = $dataset_id;
                    $convertIndexToSIj[$cluster][$dataset_id] = $indexPlus;
                    $indexPlus++;
                }
            }


            $pengujian = [];
            $pengujian = [
                'row' => $groupAllData,
                'result' => $SIj,
                'result_many' => $SIg,
                'kelompokHasil' => $kelompokHasil,
                'convertSIjToIndex' => $convertSIjToIndex,
                'convertIndexToSIj' => $convertIndexToSIj,
            ];

            $data['pengujian'] = $pengujian;
        }

        $this->template->admin('admin/perhitungan/main', $data);
    }
    public function submit()
    {
        $session_one = $this->session->userdata('kmeans.one');
        $session_oneToMany = $this->session->userdata('kmeans.onetomany');

        // hasil
        $hasil = $this->Hasil_model->insert($session_one['one']);

        // hasil detail
        $arrHasilDetail = [];
        foreach ($session_oneToMany as $key => $value) {
            foreach ($value as $key => $result) {
                $merge = array_merge($result, [
                    'hasil_id' => $hasil
                ]);
                $arrHasilDetail[] = $merge;
            }
        }
        $hasilDetail = $this->HasilDetail_model->insertMany($arrHasilDetail);

        if ($hasil || $hasilDetail) {
            $this->session->unset_userdata('kmeans.one');
            $this->session->unset_userdata('kmeans.onetomany');

            $this->session->set_flashdata('success', 'Berhasil menyimpan hasil');
            return redirect(base_url('Admin/Hasil'));
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan hasil');
            return redirect(base_url('Admin/Hasil'));
        }
    }
}

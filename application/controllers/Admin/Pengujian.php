<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class Pengujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Hasil/Hasil_model', 'Inisialisasi/Inisialisasi_model', 'HasilDetail/HasilDetail_model', 'InisialisasiDetail/InisialisasiDetail_model']);
    }
    public function index()
    {
        $hasil_id = htmlspecialchars($this->input->get('hasil_id'));
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Hasil', 'Admin/Hasil');
        $this->breadcrumbs->push('Pengujian', 'Admin/Pengujian?hasil_id=' . $hasil_id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Pengujian';
        $data['hasil_id'] = $hasil_id;

        // Pengujian
        // transformasi
        $kmeans = new Kmeans();
        $hasil = $this->HasilDetail_model->get(null, $hasil_id)->result();

        $arr_dataset = [];
        $arr_dataset = $kmeans->arr_dataset()['arr_dataset'];

        $dataset_id_db = array_column($hasil, 'dataset_id');
        foreach ($arr_dataset as $dataset_id => $value) {
            if (in_array($dataset_id, $dataset_id_db)) {
                $arr_dataset[$dataset_id] = $value;
            }
        }

        // transformasi
        $transformasi = [];
        $transformasi = $kmeans->transformasi($arr_dataset)['transformasi'];

        $hasil_convertKedekatan = [];
        foreach ($hasil as $key => $v_hasil) {
            $hasil_convertKedekatan[$v_hasil->dataset_id] = intval($v_hasil->cluster);
        }

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
        $this->template->admin('admin/pengujian/main', $data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class Peta extends CI_Controller
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
        $this->breadcrumbs->push('Peta', 'Admin/Peta?hasil_id=' . $hasil_id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Peta';
        $data['hasil_id'] = $hasil_id;
        $hasil = $this->HasilDetail_model->allData(null, $hasil_id)->result();

        $getHasil = [];
        foreach ($hasil as $key => $v_hasil) {
            if (strtolower(trim($v_hasil->nama_inisialisasi))  == 'desa') {
                $getHasil[$v_hasil->id_hasil_detail] = $v_hasil;
            }
        }

        $data['hasil'] = $getHasil;
        $this->template->admin('admin/peta/main', $data);
    }
    public function dataCluster()
    {
        // $coordinate = $this->session->userdata('save_session_coordinate');
        // $features = [];
        // foreach ($coordinate['id'] as $index => $value) {
        //     $hasilDetail = check_hasil_detail($value)->row();
        //     $features[] = [
        //         "type" => "Feature",
        //         "properties" => [
        //             "id" => $value,
        //             "cluster" => $hasilDetail->cluster,
        //             "felt" => null,
        //             "jarak" => $hasilDetail->jarak,
        //             "daerah" => $coordinate['daerah'][$index],
        //         ],
        //         "geometry" => [
        //             "type" => "Point",
        //             "coordinates" => $coordinate['coordinate'][$index]
        //         ]
        //     ];
        // }

        $hasil_id = htmlspecialchars($this->input->get('hasil_id', true));
        $hasil = $this->HasilDetail_model->allData(null, $hasil_id)->result();
        $getHasil = [];
        foreach ($hasil as $key => $v_hasil) {
            if (strtolower(trim($v_hasil->nama_inisialisasi))  == 'desa') {
                $getHasil[$v_hasil->id_hasil_detail] = $v_hasil;
            }
        }
        $features = [];
        foreach ($getHasil as $index => $value) {
            $coordinate = explode(',', $value->letak_coordinate);
            $features[] = [
                "type" => "Feature",
                "properties" => [
                    "id" => $value->id_inisialisasi_detail,
                    "cluster" => ($value->cluster + 1),
                    "felt" => null,
                    "jarak" => $value->jarak,
                    "daerah" => $value->nama_inisialisasi_detail,
                ],
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => $coordinate
                ]
            ];
        }
        $data = [
            "type" => "FeatureCollection",
            "crs" => [
                "type" => "name",
                "properties" => [
                    "name" => "urn:ogc:def:crs:OGC:1.3:CRS84"
                ]
            ],
            "features" => $features,
        ];

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function saveCoordinates()
    {
        $coordinate = $this->input->get('coordinates', true);
        $id = $this->input->get('id', true);
        $daerah = $this->input->get('daerah', true);
        $data = [
            'id' => $id,
            'coordinate' => $coordinate,
            'daerah' => $daerah,
        ];
        $this->session->set_userdata('save_session_coordinate', $data);
        echo json_encode($data);
    }
}

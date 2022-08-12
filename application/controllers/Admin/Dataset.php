<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class Dataset extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Dataset/Dataset_model', 'Inisialisasi/Inisialisasi_model', 'DatasetDetail/DatasetDetail_model', 'InisialisasiDetail/InisialisasiDetail_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Dataset', 'Admin/Dataset');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Dataset';
        $arr_inisialisasi = [];
        $inisialisasi = $this->Inisialisasi_model->joinData()->result();
        foreach ($inisialisasi as $key => $r_inisialisasi) {
            $arr_inisialisasi[$r_inisialisasi->id_inisialisasi][] = $r_inisialisasi;
        }
        $data['inisialisasi'] = $arr_inisialisasi;

        $this->template->admin('admin/dataset/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('kode_dataset', 'Kode Dataset', 'required|callback_validateKodeDataset');
        $this->form_validation->set_rules('inisialisasi_detail_id', 'Inisialisasi detail', 'callback_validateInisialisasiDetail');

        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if (($_POST['page']) == 'add') {
            if ($this->form_validation->run() == false) {
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {

                $data_Dataset = [
                    'kode_dataset' =>  htmlspecialchars($this->input->post('kode_dataset', true)),
                ];
                $insert_id = $this->Dataset_model->insert($data_Dataset);

                $data_DatasetDetail = [];
                $inisialisasi_detail_id = $this->input->post('inisialisasi_detail_id', true);
                foreach ($inisialisasi_detail_id as $id_inisialisasi => $v_inisialisasi_detail) {
                    $data_DatasetDetail[] = [
                        'dataset_id' =>  $insert_id,
                        'inisialisasi_id' =>  $id_inisialisasi,
                        'inisialisasi_detail_id' =>  $v_inisialisasi_detail,
                    ];
                }
                $insertDetail = $this->DatasetDetail_model->insertMany($data_DatasetDetail);

                if ($insertDetail || $insert_id) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil menambah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        } else if (($_POST['page']) == 'edit') {
            if ($this->form_validation->run() == false) {
                $id = htmlspecialchars($this->input->post('id_dataset', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_dataset', true));
                $data_Dataset = [
                    'kode_dataset' =>  htmlspecialchars($this->input->post('kode_dataset', true)),
                ];
                $update_id = $this->Dataset_model->update($data_Dataset, $id);

                $data_DatasetDetail = [];
                $inisialisasi_detail_id = $this->input->post('inisialisasi_detail_id', true);

                $id_dataset_detail = $this->input->post('id_dataset_detail', true);
                $id_dataset_detail = explode(',', $id_dataset_detail);

                $index = 0;
                $affected = [];
                foreach ($inisialisasi_detail_id as $id_inisialisasi => $v_inisialisasi_detail) {
                    $data_DatasetDetail = [
                        'dataset_id' =>  $id,
                        'inisialisasi_id' =>  $id_inisialisasi,
                        'inisialisasi_detail_id' =>  $v_inisialisasi_detail,
                    ];

                    if (isset($id_dataset_detail[$index])) {
                        $update = $this->DatasetDetail_model->update($data_DatasetDetail, $id_dataset_detail[$index]);
                        if ($update > 0) {
                            $affected[] = $update;
                        }
                    } else {
                        $update = $this->DatasetDetail_model->insert($data_DatasetDetail);
                        if ($update > 0) {
                            $affected[] = $update;
                        }
                    }
                    $index++;
                }


                if ($update || count($affected) > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil mengubah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        }
    }
    public function edit($id)
    {
        $get = $this->Dataset_model->get($id)->row();
        $dataset = $this->DatasetDetail_model->get(null, $id)->result();
        $data = [
            'row' => $get,
            'dataset' => $dataset,
        ];
        echo json_encode($data);
    }
    public function detail($id)
    {
        $get = $this->DatasetDetail_model->get(null, $id)->result();
        echo json_encode($get);
    }

    public function delete()
    {
        $id_dataset = htmlspecialchars($this->input->post('id_dataset', true));
        $delete = $this->Dataset_model->delete($id_dataset);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Error hapus data'
            ];
            echo json_encode($data);
        }
    }

    public function loadData()
    {
        $data = $this->Dataset_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->kode_dataset,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/Dataset/detail/' . $v_data->id_dataset) . '" class="btn btn-info btn-detail" data-id_dataset="' . $v_data->id_dataset . '" data-toggle="modal" data-target="#modalDetail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Admin/Dataset/edit/' . $v_data->id_dataset) . '" class="btn btn-warning btn-edit" data-id_dataset="' . $v_data->id_dataset . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Dataset/delete') . '" class="btn btn-danger btn-delete" data-id_dataset="' . $v_data->id_dataset . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function validateKodeDataset()
    {
        $check = TRUE;
        $kode_dataset = $this->input->post('kode_dataset', true);
        if ($_POST['page'] == 'add') {
            $check_Dataset = $this->db->get_where('dataset', ['kode_dataset' => $kode_dataset])->num_rows();
            if ($check_Dataset > 0) {
                $this->form_validation->set_message('validateKodeDataset', 'Kode sudah digunakan');
                $check = FALSE;
            }
        } else {
            $id_dataset = $this->input->post('id_dataset', true);
            $check_Dataset = $this->db->get_where('dataset', ['kode_dataset' => $kode_dataset, 'id_dataset <> ' => $id_dataset])->num_rows();
            if ($check_Dataset > 0) {
                $this->form_validation->set_message('validateKodeDataset', 'Kode sudah digunakan');
                $check = FALSE;
            }
        }
        return $check;
    }
    public function kodeDataset()
    {
        $kodeDataset =  kodeDataset();
        echo json_encode($kodeDataset);
    }
    public function validateInisialisasiDetail()
    {
        $check = true;
        $error = false;
        $message = null;
        $inisialisasi_detail_id = $this->input->post('inisialisasi_detail_id', true);
        foreach ($inisialisasi_detail_id as $key => $value) {
            if ($value == null) {
                $error = true;
                $message =  'Inisialisasi detail wajib diisi semua';
            }
        }

        if ($error) {
            $this->form_validation->set_message('validateInisialisasiDetail', $message);
            $check = FALSE;
        }

        return $check;
    }

    public function import()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['import']['name']) && in_array($_FILES['import']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['import']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new Xlsximport;
            }


            $spreadsheet = $reader->load($_FILES['import']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // var_dump($sheetData);
            // die;

            for ($i = 1; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if ($cek != null) {
                    $datasetDetail = [];
                    $count[] = $i;
                    // warga
                    $dataset = [
                        'kode_dataset' => kodeDataSet()
                    ];
                    $insertDataset = $this->Dataset_model->insert($dataset);
                    // $insertDataset = 1;

                    $jenis_kelamin = strtolower($sheetData[$i][1]) == 'l' ? 'laki-laki' : 'perempuan';
                    $check_datasetdetail = $this->InisialisasiDetail_model->get(null, null, trim($jenis_kelamin))->row();
                    if ($check_datasetdetail == null) {
                        var_dump($cek, $jenis_kelamin, 'jenis kelamin');
                        die;
                    }
                    $datasetDetail[] = [
                        'dataset_id' => $insertDataset,
                        'inisialisasi_id' => $check_datasetdetail->id_inisialisasi,
                        'inisialisasi_detail_id' => $check_datasetdetail->id_inisialisasi_detail,
                    ];

                    $jenis_peserta = strtolower($sheetData[$i][2]);
                    $check_datasetdetail = $this->InisialisasiDetail_model->get(null, null, trim($jenis_peserta))->row();
                    if ($check_datasetdetail == null) {
                        var_dump($cek, $jenis_peserta, 'jenis peserta');
                        die;
                    }
                    $datasetDetail[] = [
                        'dataset_id' => $insertDataset,
                        'inisialisasi_id' => $check_datasetdetail->id_inisialisasi,
                        'inisialisasi_detail_id' => $check_datasetdetail->id_inisialisasi_detail,
                    ];

                    $diagnosa = strtolower($sheetData[$i][3]);
                    $check_datasetdetail = $this->InisialisasiDetail_model->get(null, null, trim($diagnosa))->row();
                    if ($check_datasetdetail == null) {
                        var_dump($cek, $diagnosa, 'diagnosa');
                        die;
                    }
                    $datasetDetail[] = [
                        'dataset_id' => $insertDataset,
                        'inisialisasi_id' => $check_datasetdetail->id_inisialisasi,
                        'inisialisasi_detail_id' => $check_datasetdetail->id_inisialisasi_detail,
                    ];

                    $statusPulang = strtolower($sheetData[$i][4]);
                    $check_datasetdetail = $this->InisialisasiDetail_model->get(null, null, trim($statusPulang))->row();
                    if ($check_datasetdetail == null) {
                        var_dump($cek, $statusPulang, 'status pulang');
                        die;
                    }
                    $datasetDetail[] = [
                        'dataset_id' => $insertDataset,
                        'inisialisasi_id' => $check_datasetdetail->id_inisialisasi,
                        'inisialisasi_detail_id' => $check_datasetdetail->id_inisialisasi_detail,
                    ];

                    $alamat = strtolower($sheetData[$i][5]);
                    $check_datasetdetail = $this->InisialisasiDetail_model->get(null, null, trim($alamat))->row();
                    if ($check_datasetdetail == null) {
                        var_dump($cek, $alamat, 'alamat');
                        die;
                    }
                    $datasetDetail[] = [
                        'dataset_id' => $insertDataset,
                        'inisialisasi_id' => $check_datasetdetail->id_inisialisasi,
                        'inisialisasi_detail_id' => $check_datasetdetail->id_inisialisasi_detail,
                    ];

                    $rows = $this->DatasetDetail_model->insertMany($datasetDetail);
                }
            }


            if ($rows || $insertDataset) {
                $this->session->set_flashdata('success', 'Berhasil import ' . count($count) . ' data');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan import data');
            }
            return redirect(base_url('Admin/Dataset'));
        } else {
            $this->session->set_flashdata('error', 'Type file tidak sesuai format, harus excel');
            return redirect(base_url('Admin/Dataset'));
        }
    }
}

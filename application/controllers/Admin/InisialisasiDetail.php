<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class InisialisasiDetail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['InisialisasiDetail/InisialisasiDetail_model', 'Inisialisasi/Inisialisasi_model']);
    }
    public function index()
    {
        $inisialisasi_id = htmlspecialchars($this->input->get('inisialisasi_id', true));
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Inisialisasi', 'Admin/Inisialisasi');
        $this->breadcrumbs->push('Inisialisasi Detail', 'Admin/InisialisasiDetail?inisialisasi_id=' . $inisialisasi_id);
        // output

        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'InisialisasiDetail';
        $data['inisialisasi_id'] = $inisialisasi_id;
        $this->template->admin('admin/inisialisasidetail/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('nama_inisialisasi_detail', 'Nama Inisialisasi', 'required');
        $this->form_validation->set_rules('bobot_inisialisasi_detail', 'Bobot Inisialisasi', 'required');
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
                $inisialisasi_id = htmlspecialchars($this->input->post('inisialisasi_id', true));
                $inisialisasi = $this->Inisialisasi_model->get($inisialisasi_id)->row();

                $data_InisialisasiDetail = [
                    'nama_inisialisasi_detail' =>  htmlspecialchars($this->input->post('nama_inisialisasi_detail', true)),
                    'bobot_inisialisasi_detail' =>  htmlspecialchars($this->input->post('bobot_inisialisasi_detail', true)),
                    'inisialisasi_id' =>  $inisialisasi_id,
                ];
                $insert = $this->InisialisasiDetail_model->insert($data_InisialisasiDetail);
                if ($insert > 0) {
                    $coordinate = [];
                    if (strtolower($inisialisasi->nama_inisialisasi) == 'desa') {
                        $coordinate = [
                            'letak_coordinate' => $this->input->post('letak_coordinate', true),
                            'inisialisasi_detail_id' => $insert,
                        ];
                        $this->db->insert('coordinate', $coordinate);
                    }
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
                $id = htmlspecialchars($this->input->post('id_inisialisasi_detail', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $inisialisasi_id = htmlspecialchars($this->input->post('inisialisasi_id', true));
                $inisialisasi = $this->Inisialisasi_model->get($inisialisasi_id)->row();

                $id = htmlspecialchars($this->input->post('id_inisialisasi_detail', true));
                $data_InisialisasiDetail = [
                    'nama_inisialisasi_detail' =>  htmlspecialchars($this->input->post('nama_inisialisasi_detail', true)),
                    'bobot_inisialisasi_detail' =>  htmlspecialchars($this->input->post('bobot_inisialisasi_detail', true)),
                    'inisialisasi_id' =>  $inisialisasi_id,
                ];
                $update = $this->InisialisasiDetail_model->update($data_InisialisasiDetail, $id);
                if ($update > 0) {
                    $coordinate = [];
                    if (strtolower($inisialisasi->nama_inisialisasi) == 'desa') {
                        $coordinate = [
                            'letak_coordinate' => $this->input->post('letak_coordinate', true),
                            'inisialisasi_detail_id' => $id,
                        ];
                        $this->db->update('coordinate', $coordinate, [
                            'inisialisasi_detail_id' => $id
                        ]);
                    }
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
        $get = $this->InisialisasiDetail_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_inisialisasi_detail = htmlspecialchars($this->input->post('id_inisialisasi_detail', true));
        $delete = $this->InisialisasiDetail_model->delete($id_inisialisasi_detail);
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
        $inisialisasi_id = htmlspecialchars($this->input->get('inisialisasi_id', true));
        $data = $this->InisialisasiDetail_model->get(null, $inisialisasi_id)->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->nama_inisialisasi_detail,
                $v_data->bobot_inisialisasi_detail,
                $v_data->nama_inisialisasi,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/InisialisasiDetail/edit/' . $v_data->id_inisialisasi_detail) . '" class="btn btn-warning btn-edit" data-id_inisialisasi_detail="' . $v_data->id_inisialisasi_detail . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/InisialisasiDetail/delete') . '" class="btn btn-danger btn-delete" data-id_inisialisasi_detail="' . $v_data->id_inisialisasi_detail . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function import()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $inisialisasi_id = htmlspecialchars($this->input->post('inisialisasi_id', true));
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
            $Inisialisasi = [];
            for ($i = 1; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if ($cek != null) {
                    $count[] = $i;
                    // warga
                    $Inisialisasi[] = [
                        'nama_inisialisasi_detail' => $sheetData[$i]['1'],
                        'bobot_inisialisasi_detail' => $sheetData[$i]['2'],
                        'inisialisasi_id' => $inisialisasi_id
                    ];
                }
            }
            $rows = $this->InisialisasiDetail_model->insertMany($Inisialisasi);


            if ($rows) {
                $this->session->set_flashdata('success', 'Berhasil import ' . count($count) . ' data');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan import data');
            }
            return redirect(base_url('Admin/InisialisasiDetail?inisialisasi_id=' . $inisialisasi_id));
        } else {
            $this->session->set_flashdata('error', 'Type file tidak sesuai format, harus excel');
            return redirect(base_url('Admin/InisialisasiDetail?inisialisasi_id=' . $inisialisasi_id));
        }
    }
}

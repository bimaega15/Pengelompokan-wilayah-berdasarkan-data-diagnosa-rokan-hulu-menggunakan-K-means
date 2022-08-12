<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class Inisialisasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Inisialisasi/Inisialisasi_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Inisialisasi', 'Admin/Inisialisasi');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Inisialisasi';
        $this->template->admin('admin/inisialisasi/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('nama_inisialisasi', 'Nama Inisialisasi', 'required');
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
                $data_Inisialisasi = [
                    'nama_inisialisasi' =>  htmlspecialchars($this->input->post('nama_inisialisasi', true)),
                ];
                $insert = $this->Inisialisasi_model->insert($data_Inisialisasi);
                if ($insert > 0) {
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
                $id = htmlspecialchars($this->input->post('id_inisialisasi', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_inisialisasi', true));
                $data_Inisialisasi = [
                    'nama_inisialisasi' =>  htmlspecialchars($this->input->post('nama_inisialisasi', true)),
                ];
                $update = $this->Inisialisasi_model->update($data_Inisialisasi, $id);
                if ($update > 0) {
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

        $get = $this->Inisialisasi_model->get($id)->row();

        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_inisialisasi = htmlspecialchars($this->input->post('id_inisialisasi', true));
        $delete = $this->Inisialisasi_model->delete($id_inisialisasi);
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
        $data = $this->Inisialisasi_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->nama_inisialisasi,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/InisialisasiDetail?inisialisasi_id=' . $v_data->id_inisialisasi) . '" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Admin/Inisialisasi/edit/' . $v_data->id_inisialisasi) . '" class="btn btn-warning btn-edit" data-id_inisialisasi="' . $v_data->id_inisialisasi . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Inisialisasi/delete') . '" class="btn btn-danger btn-delete" data-id_inisialisasi="' . $v_data->id_inisialisasi . '">
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
                        'nama_inisialisasi' => $sheetData[$i]['1'],
                    ];
                }
            }
            $rows = $this->Inisialisasi_model->insertMany($Inisialisasi);


            if ($rows) {
                $this->session->set_flashdata('success', 'Berhasil import ' . $rows . ' data');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan import data');
            }
            return redirect(base_url('Admin/Inisialisasi'));
        } else {
            $this->session->set_flashdata('error', 'Type file tidak sesuai format, harus excel');
            return redirect(base_url('Admin/Inisialisasi'));
        }
    }
}

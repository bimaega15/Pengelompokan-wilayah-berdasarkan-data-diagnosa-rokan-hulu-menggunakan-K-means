<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class Hasil extends CI_Controller
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
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Hasil', 'Admin/Hasil');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Hasil';
        $this->template->admin('admin/hasil/main', $data);
    }

    public function detail($id)
    {
        $get = $this->HasilDetail_model->get(null, $id)->result();
        echo json_encode($get);
    }

    public function delete()
    {
        $id_hasil = htmlspecialchars($this->input->post('id_hasil', true));
        $delete = $this->Hasil_model->delete($id_hasil);
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
        $data = $this->Hasil_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $jenis_kelamin_profile = $v_data->jenis_kelamin_profile == 'L' ? "Laki-laki" : "Perempuan";
            $gambar_profile = base_url('public/image/users/' . $v_data->gambar_profile);
            $result['data'][] = [
                $no++,
                $v_data->nama_profile,
                '<img src="' . $gambar_profile . '" width="100px;" class="rounded img-thumbnail"></img>',
                $v_data->iterasi,
                $v_data->jumlah_cluster,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/Hasil/detail/' . $v_data->id_hasil) . '" class="btn btn-info btn-detail" data-id_hasil="' . $v_data->id_hasil . '" data-toggle="modal" data-target="#modalDetail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Admin/Hasil/delete') . '" class="btn btn-danger btn-delete" data-id_hasil="' . $v_data->id_hasil . '">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="' . base_url('Admin/Peta?hasil_id=' . $v_data->id_hasil) . '" class="btn btn-success">
                        <i class="fas fa-map-marked"></i>
                    </a>
                    <a href="' . base_url('Admin/Pengujian?hasil_id=' . $v_data->id_hasil) . '" class="btn btn-primary" title="Pengujian">
                        <i class="far fa-file-alt"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
}

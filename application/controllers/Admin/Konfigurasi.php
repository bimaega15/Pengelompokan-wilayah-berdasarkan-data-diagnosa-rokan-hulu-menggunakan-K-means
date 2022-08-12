<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();

        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model('Konfigurasi/Konfigurasi_model');
    }
    public function index()
    {

        $data['title'] = 'Konfigurasi';
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Konfigurasi', 'Admin/Konfigurasi');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $result = $this->db->get('konfigurasi')->row();
        $data['page'] = $result != null ? 'edit' : 'add';
        $data['row'] = $result;
        $this->template->admin('admin/konfigurasi/main', $data);
    }
    public function process()
    {
        $page = $this->input->post('page');
        $check = null;
        if ($page == 'edit') {
            $check = $this->Konfigurasi_model->get()->row();
            $id_konfigurasi = $check->id_konfigurasi;
            $gambar_konfigurasi = $this->uploadGambar($id_konfigurasi);
            $data = [
                'instansi_konfigurasi' => $this->input->post('instansi_konfigurasi', true),
                'nama_konfigurasi' => $this->input->post('nama_konfigurasi', true),
                'nohp_konfigurasi' => $this->input->post('nohp_konfigurasi', true),
                'alamat_konfigurasi' => $this->input->post('alamat_konfigurasi', true),
                'email_konfigurasi' => $this->input->post('email_konfigurasi', true),
                'gambar_konfigurasi' => $gambar_konfigurasi,
                'copyright_konfigurasi' => $this->input->post('copyright_konfigurasi', true),
                'tentang_konfigurasi' => $this->input->post('tentang_konfigurasi', true),

            ];
            $rowDb = $this->db->update('konfigurasi', $data, ['id_konfigurasi' => $id_konfigurasi]);
        } else {
            $data = [
                'instansi_konfigurasi' => $this->input->post('instansi_konfigurasi', true),
                'nama_konfigurasi' => $this->input->post('nama_konfigurasi', true),
                'nohp_konfigurasi' => $this->input->post('nohp_konfigurasi', true),
                'alamat_konfigurasi' => $this->input->post('alamat_konfigurasi', true),
                'email_konfigurasi' => $this->input->post('email_konfigurasi', true),
                'gambar_konfigurasi' => $this->uploadGambar(),
                'copyright_konfigurasi' => $this->input->post('copyright_konfigurasi', true),
                'tentang_konfigurasi' => $this->input->post('tentang_konfigurasi', true),
            ];
            $rowDb = $this->db->insert('konfigurasi', $data);
        }
        $status = $check == null ? 'Insert' : 'Update';
        if ($rowDb > 0) {
            $this->session->set_flashdata('success', 'Berhasil ' . $status . ' konfigurasi');
        } else {
            $this->session->set_flashdata('error', 'Gagal ' . $status . ' konfigurasi');
        }
        return redirect(base_url('Admin/Konfigurasi'));
    }
    private function uploadGambar($id = null)
    {
        $gambar = $_FILES['gambar_konfigurasi']['name'];
        if ($gambar != null) {
            if ($id != null) {
                $this->removeImage($id);
            }
            $config['upload_path'] = './public/image/konfigurasi';
            $config['allowed_types'] = 'jpg|png|jpeg|bif|gif|svg';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_konfigurasi"]['name'];
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('gambar_konfigurasi')) {
                echo $this->upload->display_errors();
            } else {
                $gambar = $this->upload->data();
                return $gambar['file_name'];
            }
        } else {
            if ($id != null) {
                $data = $this->db->get_where('konfigurasi', ['id_konfigurasi' => $id])->row();
                if ($data != null) {
                    return $data->gambar_konfigurasi;
                }
            }
            return 'default.png';
        }
    }
    private function removeImage($id)
    {
        $konfigurasi = $this->Konfigurasi_model->get($id)->row();
        if ($konfigurasi != null) {
            if ($konfigurasi->gambar_konfigurasi != null) {
                $filename = explode('.', $konfigurasi->gambar_konfigurasi)[0];
                return array_map('unlink', glob(FCPATH . "public/image/konfigurasi/" . $filename . '.*'));
            }
        }
    }
}

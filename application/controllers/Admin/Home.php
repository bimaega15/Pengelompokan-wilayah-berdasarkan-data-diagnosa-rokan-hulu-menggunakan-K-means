<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();

        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Inisialisasi/Inisialisasi_model', 'Dataset/Dataset_model', 'Users/Users_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Dashboard';
        $data['dataset'] = $this->Dataset_model->get()->num_rows();
        $data['inisialisasi'] = $this->Inisialisasi_model->get()->num_rows();
        $data['users'] = $this->Users_model->get()->num_rows();

        $this->template->admin('admin/home/main', $data);
    }
}

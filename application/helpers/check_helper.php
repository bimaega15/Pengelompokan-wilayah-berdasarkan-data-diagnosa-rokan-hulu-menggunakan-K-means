<?php
function check_already_login()
{
    $ci = &get_instance();
    if (get_cookie('cookie') != null) {
        $cookie = get_cookie('cookie');
        $users = $ci->db->get_where("users", ['cookie' => $cookie])->row();
        $ci->session->set_userdata('id_users', $users->id_users);
    }
    $session = $ci->session->userdata('id_users');
    if (!empty($session)) {
        redirect(base_url('Admin/Home'));
    }
}
function tanggal_indo($tanggal = null)
{
    if ($tanggal != null) {
        $explode = explode('-', $tanggal);
        $data_tanggal = [];
        $data_tanggal[0] = $explode[2];
        $data_tanggal[1] = $explode[1];
        $data_tanggal[2] = $explode[0];
        $output = implode('-', $data_tanggal);
        return $output;
    }
}
function check_not_login()
{
    $ci = &get_instance();
    if (!$ci->session->has_userdata('id_users')) {
        redirect(base_url('Login'));
    }
}

function numeric($number)
{
    $output = number_format($number, 0, '.', ',');
    return $output;
}
function check_profile()
{
    $ci = &get_instance();
    $ci->load->model('Users/Users_model');
    $session_id = $ci->session->userdata('id_users');
    $rows = $ci->Users_model->get($session_id)->row();
    return $rows;
}

function wordTextSlider($text, $limit)
{
    if (strlen($text) > $limit) {
        $word = strip_tags($text);
        $word = mb_substr($word, 0, $limit) . " ... ";
    } else {
        $word = $text;
    }
    return ($word);
}

function konfigurasi()
{
    $ci = &get_instance();
    $get = $ci->db->get('konfigurasi')->row();
    return $get;
}

function kodeDataSet()
{
    $ci = &get_instance();
    $ci->load->model('Dataset/Dataset_model');

    $kodeDataSet = $ci->Dataset_model->maxKode()->result();
    $getKode = [];
    foreach ($kodeDataSet as $key => $value) {
        $getKode[] = substr($value->kode_dataset, 1);
    }
    $max = max($getKode);
    $kodeDataSet = $max;
    if ($kodeDataSet == null) {
        $kodeDataSet = 0;
    }
    $urutan = $kodeDataSet;
    $urutan++;

    $huruf = "P";
    $kodeDataSet = $huruf . $urutan;
    return $kodeDataSet;
}

function check_inisialisasi($inisialisasi_id = null)
{
    $ci = &get_instance();
    $ci->load->model('Inisialisasi/Inisialisasi_model');

    $getInisialisasi = $ci->Inisialisasi_model->get($inisialisasi_id);
    return $getInisialisasi;
}
function check_dataset($dataset_id = null)
{
    $ci = &get_instance();
    $ci->load->model('Dataset/Dataset_model');

    $getDataset = $ci->Dataset_model->get($dataset_id);
    return $getDataset;
}
function check_hasil_detail($id_hasil_detail = null)
{
    $ci = &get_instance();
    $ci->load->model('HasilDetail/HasilDetail_model');

    $getHasilDetail = $ci->HasilDetail_model->get($id_hasil_detail);
    return $getHasilDetail;
}

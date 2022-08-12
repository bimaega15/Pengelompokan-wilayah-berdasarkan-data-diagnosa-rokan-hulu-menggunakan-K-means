<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Users/Users_model', 'Profile/Profile_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Users', 'Admin/Users');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Users';
        $this->template->admin('admin/users/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_validateUsername');
        $this->form_validation->set_rules('password', 'Password', 'callback_validatePassword');
        $this->form_validation->set_rules('level', 'Level', 'required');

        $this->form_validation->set_rules('nama_profile', 'Nama', 'required');
        $this->form_validation->set_rules('alamat_profile', 'Alamat', 'required');
        $this->form_validation->set_rules('nohp_profile', 'No. HP', 'required');
        $this->form_validation->set_rules('jenis_kelamin_profile', 'Jenis kelamin', 'required');
        $this->form_validation->set_rules('gambar_profile', 'Gambar', 'callback_validateGambar');
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
                $data_Users = [
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => htmlspecialchars(md5($this->input->post('password', true))),
                    'level' => htmlspecialchars($this->input->post('level', true)),
                ];
                $insertUsers = $this->Users_model->insert($data_Users);

                $gambarProfile = $this->uploadGambar();
                $dataProfile = [
                    'nama_profile' => htmlspecialchars($this->input->post('nama_profile', true)),
                    'alamat_profile' => htmlspecialchars($this->input->post('alamat_profile', true)),
                    'nohp_profile' => htmlspecialchars($this->input->post('nohp_profile', true)),
                    'jenis_kelamin_profile' => htmlspecialchars($this->input->post('jenis_kelamin_profile', true)),
                    'gambar_profile' => $gambarProfile,
                    'users_id' => $insertUsers,
                ];
                $insertProfile = $this->Profile_model->insert($dataProfile);
                if ($insertProfile > 0 || $insertUsers > 0) {
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
                $id = htmlspecialchars($this->input->post('id_users', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_users', true));
                $password = $this->input->post('password', true);
                $password_db = $this->input->post('password_old', true);
                if ($password != null) {
                    $password_db = htmlspecialchars(md5($password));
                }

                $data_Users = [
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => $password_db,
                    'level' => htmlspecialchars($this->input->post('level', true)),
                ];
                $updateUsers = $this->Users_model->update($data_Users, $id);

                $profile_id = htmlspecialchars($this->input->post('profile_id', true));
                $gambarProfile = $this->uploadGambar($id);
                $dataProfile = [
                    'nama_profile' => htmlspecialchars($this->input->post('nama_profile', true)),
                    'alamat_profile' => htmlspecialchars($this->input->post('alamat_profile', true)),
                    'nohp_profile' => htmlspecialchars($this->input->post('nohp_profile', true)),
                    'jenis_kelamin_profile' => htmlspecialchars($this->input->post('jenis_kelamin_profile', true)),
                    'gambar_profile' => $gambarProfile,
                    'users_id' => $id,
                ];
                $updateProfile = $this->Profile_model->update($dataProfile, $profile_id);

                if ($updateUsers > 0 || $updateProfile > 0) {
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
        $get = $this->Users_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_users = htmlspecialchars($this->input->post('id_users', true));
        $this->removeImage($id_users);
        $delete = $this->Users_model->delete($id_users);
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
        $data = $this->Users_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        $id_session = $this->session->userdata('id_users');
        foreach ($data as $index => $v_data) {
            $jenisKelamin = $v_data->jenis_kelamin_profile == 'L' ? 'Laki-laki' : 'Perempuan';
            $output = '<a href="' . base_url('Admin/Users/edit/' . $v_data->id_users) . '" class="btn btn-warning btn-edit" data-id_users="' . $v_data->id_users . '">
            <i class="fas fa-pencil-alt"></i>
        </a>';
            if ($id_session != $v_data->id_users) {
                $output .= '<a href="' . base_url('Admin/Users/delete') . '" class="btn btn-danger btn-delete" data-id_users="' . $v_data->id_users . '">
                <i class="fas fa-trash"></i>
            </a>';
            }
            $result['data'][] = [
                $no++,
                $v_data->username,
                $v_data->nama_profile,
                $v_data->nohp_profile,
                $v_data->alamat_profile,
                $jenisKelamin,
                '<img src="' . base_url('public/image/users/' . $v_data->gambar_profile) . '" class="img-thumbnail" width="100px;"></img>',
                '
                <div class="text-center">
                    ' . $output . '
                </div>
                '
            ];
        }
        echo json_encode($result);
    }

    public function validateGambar()
    {
        $check = TRUE;
        if (($_FILES['gambar_profile']) && $_FILES['gambar_profile']['size'] != 0) {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
            $extension = pathinfo($_FILES["gambar_profile"]["name"], PATHINFO_EXTENSION);

            if (filesize($_FILES['gambar_profile']['tmp_name']) > 1000000) {
                $this->form_validation->set_message('validateGambar', 'Gambar melebihi 1 MB');
                $check = FALSE;
            }
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('validateGambar', "Tidak didukung format {$extension}");
                $check = FALSE;
            }
        }
        return $check;
    }

    public function validatePassword()
    {
        $check = TRUE;
        $password = $this->input->post('password', true);
        $confirm_password = $this->input->post('confirm_password', true);
        if ($_POST['page'] == 'add') {
            if ($password == null) {
                $this->form_validation->set_message('validatePassword', 'Password tidak boleh kosong');
                $check = FALSE;
            }
            if ($confirm_password == null) {
                $this->form_validation->set_message('validatePassword', 'Confirm password tidak boleh kosong');
                $check = FALSE;
            }
        }
        if ($password != null && $confirm_password != null) {
            if ($password != $confirm_password) {
                $this->form_validation->set_message('validatePassword', 'Password tidak sama dengan confirm password');
                $check = FALSE;
            }
        }
        return $check;
    }

    public function validateUsername()
    {
        $check = TRUE;
        $username = $this->input->post('username', true);
        if ($_POST['page'] == 'add') {
            $check_username = $this->db->get_where('Users', ['username' => $username])->num_rows();
            if ($check_username > 0) {
                $this->form_validation->set_message('validateUsername', 'Username sudah digunakan');
                $check = FALSE;
            }
        } else {
            $id_users = $this->input->post('id_users', true);
            $check_username = $this->db->get_where('Users', ['username' => $username, 'id_users <> ' => $id_users])->num_rows();
            if ($check_username > 0) {
                $this->form_validation->set_message('validateUsername', 'Username sudah digunakan');
                $check = FALSE;
            }
        }
        return $check;
    }

    private function uploadGambar($id_users = '')
    {
        $gambar = $_FILES["gambar_profile"]['name'];
        if ($gambar != null) {
            $this->removeImage($id_users);
            $config['upload_path'] = './public/image/users';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_profile"]['name'];
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gambar_profile')) {
                echo $this->upload->display_errors();
            } else {
                $gambar = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './public/image/users/' . $gambar['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '50%';
                $config['new_image'] = './public/image/users/' . $gambar['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                return $gambar['file_name'];
            }
        } else {
            if ($id_users != null) {
                $Users = $this->Users_model->get($id_users)->row();
                if ($Users->gambar_profile != 'default.png') {
                    return $Users->gambar_profile;
                }
            }
            return 'default.png';
        }
    }

    private function removeImage($id)
    {
        if ($id != null) {
            $img = $this->Users_model->get($id)->row();
            if ($img->gambar_profile != 'default.png') {
                $filename = explode('.', $img->gambar_profile)[0];
                return array_map('unlink', glob(FCPATH . "public/image/users/" . $filename . '.*'));
            }
        }
    }
}

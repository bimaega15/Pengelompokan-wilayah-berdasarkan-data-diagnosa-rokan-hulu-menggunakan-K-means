<?php
class Users_model extends CI_Model
{
    public function login($username = null, $password = null)
    {
        $this->db->select('*');
        $this->db->from('users');
        if ($username != null) {
            $this->db->where('username', $username);
        }
        if ($password != null) {
            $this->db->where('password', md5($password));
        }
        return $this->db->get();
    }
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('users u');
        $this->db->join('profile p', 'p.users_id = u.id_users');
        if ($id != null) {
            $this->db->where('u.id_users', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_users)
    {
        $this->db->where('id_users', $id_users);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }
    public function insert($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    public function delete($id_users)
    {
        $this->db->delete('users', ['id_users' => $id_users]);
        return $this->db->affected_rows();
    }
}

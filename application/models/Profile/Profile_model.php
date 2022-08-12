<?php
class Profile_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('profile');
        if ($id != null) {
            $this->db->where('id_profile', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_profile)
    {
        $this->db->where('id_profile', $id_profile);
        $this->db->update('profile', $data);
        return $this->db->affected_rows();
    }
    public function insert($data)
    {
        $this->db->insert('profile', $data);
        return $this->db->insert_id();
    }
    public function delete($id_profile)
    {
        $this->db->delete('profile', ['id_profile' => $id_profile]);
        return $this->db->affected_rows();
    }
}

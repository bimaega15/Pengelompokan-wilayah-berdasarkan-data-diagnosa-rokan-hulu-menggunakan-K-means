<?php
class Hasil_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('hasil h');
        $this->db->join('users u', 'u.id_users = h.users_id', 'left');
        $this->db->join('profile p', 'p.users_id = u.id_users', 'left');
        if ($id != null) {
            $this->db->where('id_hasil', $id);
        }
        return $this->db->get();
    }

    public function update($data, $id_hasil)
    {
        $this->db->where('id_hasil', $id_hasil);
        $this->db->update('hasil', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('hasil', $data);
        return $this->db->insert_id();
    }

    public function delete($id_hasil)
    {
        $this->db->delete('hasil', ['id_hasil' => $id_hasil]);
        return $this->db->affected_rows();
    }
    public function maxKode()
    {
        $this->db->select('kode_hasil');
        $this->db->from('hasil');
        return $this->db->get();
    }
}
